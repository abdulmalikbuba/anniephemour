<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Security\Security;
use SilverStripe\Security\MemberAuthenticator\MemberAuthenticator;
use SilverStripe\Security\PasswordValidator;

class AccountController extends PageController
{
    private static $allowed_actions = [
        'orders',
        'updateProfile',
        'changePassword'
    ];

    protected function init()
    {
        parent::init();

        if (!Security::getCurrentUser()) {
            // Set the session message to notify the user that they need to log in
            $this->setSessionMessage('Please log in to access your account!', 'warning');
        
            // Redirect the user to the login page with the BackURL pointing to the dashboard
            return $this->redirectBack();
        }
        
    }

    public function Link($action = null)
    {
        return "account/$action";
    }

    public function index(HTTPRequest $request)
    {
        $member = Security::getCurrentUser();
        if (!$member) {
            return $this->httpError(403, 'You need to be logged in to view your account details!');
        }

        return $this->customise([
            'Title' => 'Account',
            'PageTitle' => 'Account Details',
            'BannerTitle' => 'My Account',
        ]);
    }

    public function orders()
    {
        // Get the current user
        $member = Security::getCurrentUser();
        if (!$member) {
            return $this->httpError(403, 'You need to be logged in to view your orders!');
        }

        // Retrieve all orders for the current user
        $orders = Order::get()->filter(['MemberID' => $member->ID])->sort('Created', 'DESC');

        return $this->customise([
            'Title' => 'Account',
            'PageTitle' => 'Orders',
            'BannerTitle' => 'My Orders',
            'Orders' => $orders
        ]);
    }


    public function updateProfile(HTTPRequest $request)
    {
        // Get the currently logged-in user
        $member = Security::getCurrentUser();
        if (!$member) {
            // Redirect to login if not logged in
            return $this->redirect('Security/login');
        }

        // Handle form submission
        if ($request->isPOST()) {
            // Get the form input
            $firstName = $request->postVar('FirstName');
            $surname = $request->postVar('Surname');
            $email = $request->postVar('Email');
            $phoneNumber = $request->postVar('PhoneNumber');
            $address = $request->postVar('Address');

            // Validate email (optional)
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setSessionMessage('Invalid email format!', 'danger');
                return $this->redirectBack();
            }

            // Update member details
            $member->FirstName = $firstName;
            $member->Surname = $surname;
            $member->Email = $email;
            $member->PhoneNumber = $phoneNumber;
            $member->Address = $address;

            try {
                $member->write();
                $this->setSessionMessage('Profile updated successfully!', 'success');
            } catch (ValidationException $e) {
                $this->setSessionMessage('Error updating profile: ' . $e->getMessage(), 'danger');
            }

            return $this->redirectBack();
        }

        return $this->httpError(400, 'Invalid request method');
    }

    public function changePassword(HTTPRequest $request)
    {
        $member = Security::getCurrentUser();
        if (!$member) {
            return $this->redirect('Security/login');
        }

        // Handle form submission
        if ($request->isPOST()) {
            $currentPassword = $request->postVar('CurrentPassword');
            $newPassword = $request->postVar('NewPassword');
            $confirmPassword = $request->postVar('ConfirmPassword');

            // Check if new passwords match
            if ($newPassword !== $confirmPassword) {
                $this->setSessionMessage('New passwords do not match!', 'danger');
                return $this->redirectBack();
            }

            // Authenticate current password
            $authenticator = new MemberAuthenticator();
            $result = $authenticator->checkPassword($member, $currentPassword);

            if (!$result->isValid()) {
                $this->setSessionMessage('Incorrect current password!', 'danger');
                return $this->redirectBack();
            }

            // Update password
            try {
                $member->changePassword($newPassword);
                $this->setSessionMessage('Password changed successfully!', 'success');
            } catch (ValidationException $e) {
                $this->setSessionMessage('Error changing password: ' . $e->getMessage(), 'danger');
            }

            return $this->redirectBack();
        }

        return $this->httpError(400, 'Invalid request method');
    }


    private function setSessionMessage($message, $type = 'success')
    {
        $session = $this->getRequest()->getSession();
        $session->set("Page.message", $message);
        $session->set("Page.messageType", $type);
    }

}