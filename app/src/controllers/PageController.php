<?php

namespace {

    use SilverStripe\View\ArrayData;
    use SilverStripe\ORM\ValidationResult;
    use SilverStripe\Core\Injector\Injector;
    use SilverStripe\Security\Authenticator;
    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\Requirements;
    use SilverStripe\Security\Member;
    use SilverStripe\Security\Security;
    use SilverStripe\Control\HTTPRequest;
    use SilverStripe\Security\IdentityStore;
    use SilverStripe\ORM\FieldType\DBHTMLText;
    
    /**
     * @template T of Page
     * @extends ContentController<T>
     */
    class PageController extends ContentController
    {
        /**
         * An array of actions that can be accessed via a request. Each array element should be an action name, and the
         * permissions or conditions required to allow the user to access it.
         *
         * <code>
         * [
         *     'action', // anyone can access this action
         *     'action' => true, // same as above
         *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
         *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
         * ];
         * </code>
         *
         * @var array
         */
        private static $allowed_actions = ['login', 'doSignup', 'logout', 'subscribe'];

        protected function init()
        {
            parent::init();
            // You can include any CSS or JS required by your project here.
            // See: https://docs.silverstripe.org/en/developer_guides/templates/requirements/

            $ThemeDir = "app/";

            Requirements::css($ThemeDir . 'css/style.css');
            Requirements::css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
            Requirements::css('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');
            Requirements::css($ThemeDir . 'css/lib/animate/animate.min.css');
            Requirements::css($ThemeDir . 'css/lib/lightbox/css/lightbox.min.css');
            Requirements::css('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200..900;1,200..900&display=swap');

            Requirements::javascript('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
            Requirements::javascript('https://code.jquery.com/jquery-3.4.1.min.js');
            Requirements::javascript($ThemeDir . 'css/lib/easing/easing.min.js');
            Requirements::javascript($ThemeDir . 'css/lib/wow/wow.min.js');
            Requirements::javascript($ThemeDir . 'css/lib/lightbox/js/lightbox.min.js');

            Requirements::customScript(<<<JS
                new WOW().init();

                $('.add-to-cart-btn').click(function() {
                    var toastEl = document.getElementById('cartToast');
                    var toast = new bootstrap.Toast(toastEl);
                    toast.show();
                });

                // Example: Show toast message after removing item from cart
                $('.remove-from-cart-btn').click(function() {
                    var toastEl = document.getElementById('removeToast');
                    var toast = new bootstrap.Toast(toastEl);
                    toast.show();
                });
                
            JS);
        }

        public function login(HTTPRequest $request)
        {
            if (!$request->isPOST()) {
                return $this->httpError(400, 'Bad Method Request');
            }

            $email = $request->postVar('Email');
            $password = $request->postVar('password');

            if (!$email || !$password) {
                $this->setSessionMessage('Email and Password are required!', 'danger');
                return $this->redirectBack();
            }

            $member = Member::get()->filter(['Email' => $email])->first();

            if (!$member) {
                $this->setSessionMessage('Account not found!', 'danger');
                return $this->redirectBack();
            }

            $result = ValidationResult::create();
            $authenticators = Security::singleton()->getApplicableAuthenticators(Authenticator::CHECK_PASSWORD);
            foreach ($authenticators as $authenticator) {
                $authenticator->checkPassword($member, $password, $result);
                if (!$result->isValid()) {
                    break;
                }
            }

            if ($result->isValid()) {
                $identityStore = Injector::inst()->get(IdentityStore::class);
                $identityStore->logIn($member, $request->postVar('remember-me') ? true : false, $request);

                $member->LastLogin = date('Y-m-d H:i:s');
                $member->write();

                $this->setSessionMessage('Welcome Back!', 'success');

                $backURL = $request->getVar('BackURL') ?: 'home';
                return $this->redirect($backURL);
            }

            $this->setSessionMessage('Invalid Credentials!', 'danger');
            return $this->redirectBack();
        }

        public function doSignup(HTTPRequest $request)
        {
            if (!$request->isPOST()) {
                return $this->httpError(400, 'Bad Method Request');
            }

            $fullName = $request->postVar('Name');
            $email = $request->postVar('Email');
            $phonenumber = $request->postVar('PhoneNumber');
            $password = $request->postVar('password');
            $confirmPassword = $request->postVar('confirmPassword');

            if (!$fullName || !$email || !$password || !$confirmPassword) {
                $this->setSessionMessage('All fields are required!', 'danger');
                return $this->redirectBack();
            }

            if ($password !== $confirmPassword) {
                $this->setSessionMessage('Passwords do not match!', 'danger');
                return $this->redirectBack();
            }

            // Split full name into first name and surname
            $nameParts = explode(' ', $fullName);
            $firstName = array_shift($nameParts);
            $surname = implode(' ', $nameParts);

            // Check if the email is already taken
            $existingMember = Member::get()->filter('Email', $email)->first();
            if ($existingMember) {
                $this->setSessionMessage('Email is already taken!', 'danger');
                return $this->redirectBack();
            }

            // Create a new member
            $member = Member::create();
            $member->FirstName = $firstName;
            $member->Surname = $surname;
            $member->Email = $email;
            $member->PhoneNumber = $phonenumber;
            $member->changePassword($password);

            $member->write();

            $member->addToGroupByCode("Users");

            // Log the user in after sign-up
            $identityStore = Injector::inst()->get(IdentityStore::class);
            $identityStore->logIn($member, false, $request);

            $this->setSessionMessage('Account created successfully!', 'success');
            return $this->redirect('home');
        }

        public function logout(HTTPRequest $request)
        {
            $identityStore = Injector::inst()->get(IdentityStore::class);
            $identityStore->logOut();
            return $this->redirect('home');
        }

        public function CartItemCount()
        {
            // Fetch the current logged-in user
            $member = Security::getCurrentUser();

            if ($member) {
                // Fetch the cart associated with the current user
                $cart = Cart::get()->filter('MemberID', $member->ID)->first();

                if ($cart) {
                    // Get the count of items in the cart
                    $itemCount = $cart->CartItems()->count();
                    return $itemCount;
                }
            }

            return 0; // Return 0 if no cart or no user logged in
        }

        public function subscribe(HTTPRequest $request)
        {
            if (!$request->isPOST()) {
                return $this->httpError(400, 'Bad Method Request');
            }

            $email = $request->postVar('Email');
            
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setSessionMessage('Please enter a valid email address!', 'danger');
                return $this->redirectBack();
            }

            // Example logic to save the email to a database
            $subscription = NewsletterSubscription::create();
            $subscription->Email = $email;
            $subscription->write();

            $this->setSessionMessage('Thank you for subscribing to our newsletter!', 'success');
            return $this->redirectBack();
        }




        private function setSessionMessage($message, $type = 'success')
        {
            $session = $this->getRequest()->getSession();
            $session->set("Page.message", $message);
            $session->set("Page.messageType", $type);
        }

        public function SessionMessage()
        {
            $session = $this->getRequest()->getSession();

            $Message = $session->get('Page.message');
            $Type = $session->get('Page.messageType');

            $session->clear('Page.message');
            $session->clear('Page.messageType');

            if ($Message) {
                return DBHTMLText::create()->setValue(
                    sprintf(
                        '<div class="toast-container position-fixed top-5 end-0 p-3">
                            <div class="toast align-items-center text-bg-%s border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        %s
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>',
                        $Type,
                        $Message
                    )
                );
            }

            return false;
        }

        public function ClearSessionMessage()
        {
            $session = $this->getRequest()->getSession();
            $session->clear('Page.message');
            $session->clear('Page.messageType');
        }

    }
}
