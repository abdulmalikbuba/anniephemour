<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Security;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\ValidationException;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Config\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CartController extends PageController
{
    private static $allowed_actions = [
        'addToCart',
        'removeFromCart',
        'updateQuantity',
        'purchase',
        'pay',
        'callback'
    ];

    protected function init()
    {
        parent::init();
        // You can include any CSS or JS required by your project here.
        // See: https://docs.silverstripe.org/en/developer_guides/templates/requirements/

        Requirements::javascript('https://js.paystack.co/v1/inline.js');

        Requirements::customScript(<<<JS
            
        JS);
    }



    public function Link($action = null)
    {
        return Controller::join_links('cart', $action);
    }

    public function index()
    {
        $session = $this->getRequest()->getSession();
        $cartMessage = $session->get('CartMessage');
        $session->clear('CartMessage');

        return $this->customise([
            'Cart' => $this->getCart(),
            'CartMessage' => $cartMessage
        ])->renderWith(['Cart', 'Page']);
    }

    private function getCart()
    {
        $member = Security::getCurrentUser();
        if ($member) {
            $cart = Cart::get()->filter(['MemberID' => $member->ID])->first();
            if (!$cart) {
                $cart = Cart::create(['MemberID' => $member->ID]);
                $cart->write();
            }
        } else {
            $session = $this->getRequest()->getSession();
            $sessionID = $session->get('Cart.SessionID');
            if (!$sessionID) {
                $sessionID = session_id();
                $session->set('Cart.SessionID', $sessionID);
            }
            $cart = Cart::get()->filter(['SessionID' => $sessionID])->first();
            if (!$cart) {
                $cart = Cart::create(['SessionID' => $sessionID]);
                $cart->write();
            }
        }
        return $cart;
    }
    
    public function addToCart(HTTPRequest $request)
    {
        if (!Security::getCurrentUser()) {
            // User is not logged in, redirect to login page or show an error message
            $this->setSessionMessage('You must be logged in to add items to the cart!', 'danger');
            return $this->redirectBack();
        }

        $bookID = $request->postVar('BookID');
        if (!$bookID) {
            $this->setSessionMessage('No book selected!', 'danger');
            return $this->redirectBack();
        }

        $book = Book::get()->byID($bookID);
        if (!$book) {
            $this->setSessionMessage('Book not found!', 'danger');
            return $this->redirectBack();
        }

        $cart = $this->getCart();
        $cartItem = $cart->CartItems()->filter(['BookID' => $bookID])->first();

        if ($cartItem) {
            // Book is already in the cart, update quantity and price
            $cartItem->Quantity += 1;
            $cartItem->TotalPrice = $cartItem->Quantity * $book->Price; // Assuming Price is a field on your Book model
        } else {
            // Book is not in the cart, add it as a new cart item
            $cartItem = CartItem::create([
                'BookID' => $bookID,
                'Quantity' => 1,
                'TotalPrice' => $book->Price, // Initial total price for one item
                'CartID' => $cart->ID
            ]);
        }

        try {
            $cartItem->write();
            $this->setSessionMessage('Book added to cart successfully!', 'success');
        } catch (ValidationException $ex) {
            $this->setSessionMessage('Error adding book to cart: ' . $ex->getMessage(), 'danger');
        }

        return $this->redirectBack();
    }

    public function updateQuantity(HTTPRequest $request)
    {
        $cartItemID = $request->postVar('CartItemID');
        $quantity = (int) $request->postVar('Quantity');

        // Validate inputs
        if (!$cartItemID || $quantity <= 0) {
            $this->setSessionMessage('Invalid input!', 'danger');
            return $this->redirectBack();
        }

        $cartItem = CartItem::get()->byID($cartItemID);

        if ($cartItem) {
            // Update quantity and total price
            $cartItem->Quantity = $quantity;
            $cartItem->TotalPrice = $cartItem->Book()->Price * $quantity; // Assuming Price is a field on your Book model
            try {
                $cartItem->write();
                $this->setSessionMessage('Quantity updated successfully!', 'success');
            } catch (ValidationException $ex) {
                $this->setSessionMessage('Error updating quantity: ' . $ex->getMessage(), 'danger');
            }
        } else {
            $this->setSessionMessage('Cart item not found!', 'danger');
        }

        return $this->redirectBack();
    }


    public function removeFromCart(HTTPRequest $request)
    {
        $cartItemID = $request->postVar('CartItemID');
        if (!$cartItemID) {
            $this->setSessionMessage('Invalid Cart Item!', 'danger');
            return $this->redirectBack();
        }

        $member = Security::getCurrentUser();
        $session = $request->getSession();
        $sessionID = $session->get('Cart.SessionID');

        if ($member) {
            $cart = Cart::get()->filter(['MemberID' => $member->ID])->first();
        } else {
            $cart = Cart::get()->filter(['SessionID' => $sessionID])->first();
        }

        if (!$cart) {
            $this->setSessionMessage('Cart not found!', 'danger');
            return $this->redirectBack();
        }

        $cartItem = CartItem::get()->byID($cartItemID);
        if (!$cartItem) {
            $this->setSessionMessage('Cart Item not found!', 'danger');
            return $this->redirectBack();
        }

        // Check if the cart item belongs to the current cart
        if ($cartItem->CartID !== $cart->ID) {
            $this->setSessionMessage('Cart Item does not belong to your cart!', 'danger');
            return $this->redirectBack();
        }

        $cartItem->delete();
        $this->setSessionMessage('Item removed from cart!', 'success');
        return $this->redirectBack();
    }

    
    // public function purchase()
    // {
    //     $member = Security::getCurrentUser();
    //     if (!$member) {
    //         $this->setSessionMessage('You must be logged in to purchase items!', 'danger');
    //         return $this->redirectBack();
    //     }

    //     $cart = $this->getCart();
    //     if (!$cart || !$cart->CartItems()->exists()) {
    //         $this->setSessionMessage('Your cart is empty!', 'danger');
    //         return $this->redirectBack();
    //     }

    //     $order = Order::create([
    //         'MemberID' => $member->ID,
    //         'TotalPrice' => $cart->Total,
    //         'Status' => 'Pending'
    //     ]);
    //     $order->write();

    //     foreach ($cart->CartItems() as $cartItem) {
    //         $orderItem = OrderItem::create([
    //             'OrderID' => $order->ID,
    //             'BookID' => $cartItem->BookID,
    //             'Quantity' => $cartItem->Quantity,
    //             'TotalPrice' => $cartItem->TotalPrice
    //         ]);
    //         $orderItem->write();
    //     }

    //     $payment = Payment::create([
    //         'Amount' => $order->TotalPrice,
    //         'Status' => 'Pending',
    //         'OrderID' => $order->ID,
    //         'MemberID' => $member->ID
    //     ]);

    //     $payment->write();

    //     // Redirect to Paystack payment page
    //     return $this->redirect($this->Link('pay/' . $payment->ID));
    // }

    // public function purchase()
    // {
    //     $member = Security::getCurrentUser();
    //     if (!$member) {
    //         $this->setSessionMessage('You must be logged in to purchase items!', 'danger');
    //         return $this->redirectBack();
    //     }

    //     $cart = $this->getCart();
    //     if (!$cart || !$cart->CartItems()->exists()) {
    //         $this->setSessionMessage('Your cart is empty!', 'danger');
    //         return $this->redirectBack();
    //     }

    //     $order = Order::create([
    //         'MemberID' => $member->ID,
    //         'TotalPrice' => $cart->Total,
    //         'Status' => 'Pending'
    //     ]);
    //     $order->write();

    //     foreach ($cart->CartItems() as $cartItem) {
    //         $orderItem = OrderItem::create([
    //             'OrderID' => $order->ID,
    //             'BookID' => $cartItem->BookID,
    //             'Quantity' => $cartItem->Quantity,
    //             'TotalPrice' => $cartItem->TotalPrice
    //         ]);
    //         $orderItem->write();
    //     }

    //     $payment = Payment::create([
    //         'Amount' => $order->TotalPrice,
    //         'Status' => 'Pending',
    //         'OrderID' => $order->ID,
    //         'MemberID' => $member->ID
    //     ]);
    //     $payment->write();

    //     return $this->customise([
    //         'PublicKey' => Config::inst()->get('Paystack', 'public_key'),
    //         'Email' => $member->Email,
    //         'Amount' => $payment->Amount * 100, // Convert to kobo
    //         'Reference' => $payment->ID,
    //         'CallbackUrl' => $this->Link('callback')
    //     ]);
    // }


    // public function pay($request)
    // {
    //     $paymentID = $request->param('ID');
    //     $payment = Payment::get()->byID($paymentID);

    //     if (!$payment) {
    //         $this->setSessionMessage('Payment not found!', 'danger');
    //         return $this->redirectBack();
    //     }

    //     $publicKey = Config::inst()->get('Paystack', 'public_key');
    //     $callbackUrl = $this->Link('callback');
    //     $amount = $payment->Amount * 100; // Convert to kobo
    //     $email = Security::getCurrentUser()->Email;

    //     return $this->customise([
    //         'PublicKey' => $publicKey,
    //         'CallbackUrl' => $callbackUrl,
    //         'Amount' => $amount,
    //         'Email' => $email,
    //         'Reference' => $payment->ID
    //     ])->renderWith('PaystackPayment');
    // }

    // public function callback(HTTPRequest $request)
    // {
    //     $reference = $request->getVar('reference');
    //     $payment = Payment::get()->byID($reference);

    //     if (!$payment) {
    //         $this->setSessionMessage('Payment not found!', 'danger');
    //         return $this->redirect('https://attendantgh.com/cart');
    //     }

    //     $secretKey = Config::inst()->get('Paystack', 'secret_key');
    //     $client = new Client();

    //     try {
    //         $response = $client->request('GET', "https://api.paystack.co/transaction/verify/{$reference}", [
    //             'headers' => [
    //                 'Authorization' => "Bearer $secretKey"
    //             ],
    //             'verify' => true // Optional, for SSL certificate verification
    //         ]);

    //         $result = json_decode($response->getBody());

    //         if ($result->status && $result->data->status == 'success') {
    //             // Payment was successful, update the payment and order status
    //             $payment->Status = 'Paid';
    //             $payment->write();

    //             $order = $payment->Order();
    //             if ($order) {
    //                 $order->Status = 'Pending';
    //                 $order->write();
    //             }

    //             // Clear the cart after successful payment
    //             $cart = $this->getCart();
    //             if ($cart && $cart->CartItems()->exists()) {
    //                 $cart->CartItems()->removeAll();
    //                 $cart->delete();
    //             }

    //             $this->setSessionMessage('Payment successful!', 'success');
    //             return $this->redirect('https://attendantgh.com/cart');
    //         } else {
    //             $this->setSessionMessage('Payment failed: ' . $result->data->gateway_response, 'danger');
    //             return $this->redirect('https://attendantgh.com/cart');
    //         }
    //     } catch (RequestException $e) {
    //         $this->setSessionMessage('Payment failed: ' . $e->getMessage(), 'danger');
    //         return $this->redirect('https://attendantgh.com/cart');
    //     }
    // }

    public function purchase()
    {
        $member = Security::getCurrentUser();
        if (!$member) {
            $this->setSessionMessage('You must be logged in to purchase items!', 'danger');
            return $this->redirectBack();
        }

        $cart = $this->getCart();
        if (!$cart || !$cart->CartItems()->exists()) {
            $this->setSessionMessage('Your cart is empty!', 'danger');
            return $this->redirectBack();
        }

        $order = Order::create([
            'MemberID' => $member->ID,
            'TotalPrice' => $cart->Total,
            'Status' => 'Pending'
        ]);
        $order->write();

        foreach ($cart->CartItems() as $cartItem) {
            $orderItem = OrderItem::create([
                'OrderID' => $order->ID,
                'BookID' => $cartItem->BookID,
                'Quantity' => $cartItem->Quantity,
                'TotalPrice' => $cartItem->TotalPrice
            ]);
            $orderItem->write();
        }

        $payment = Payment::create([
            'Amount' => $order->TotalPrice,
            'Status' => 'Pending',
            'OrderID' => $order->ID,
            'MemberID' => $member->ID
        ]);
        $payment->write();

        // Payment initiation logic, no rendering
        $responseData = [
            'PublicKey' => Config::inst()->get('Paystack', 'public_key'),
            'Email' => $member->Email,
            'Amount' => $payment->Amount * 100, // Convert to kobo
            'Reference' => $payment->ID,
            'CallbackUrl' => $this->Link('callback')
        ];

        return json_encode($responseData);
    }

    public function pay($request)
    {
        $paymentID = $request->param('ID');
        $payment = Payment::get()->byID($paymentID);

        if (!$payment) {
            $this->setSessionMessage('Payment not found!', 'danger');
            return $this->redirectBack();
        }

        $publicKey = Config::inst()->get('Paystack', 'public_key');
        $callbackUrl = $this->Link('callback');
        $amount = $payment->Amount * 100; // Convert to kobo
        $email = Security::getCurrentUser()->Email;

        // Payment initiation logic, no rendering
        $responseData = [
            'PublicKey' => $publicKey,
            'CallbackUrl' => $callbackUrl,
            'Amount' => $amount,
            'Email' => $email,
            'Reference' => $payment->ID
        ];

        return json_encode($responseData);
    }

    public function callback(HTTPRequest $request)
    {
        $reference = $request->getVar('reference');
        $payment = Payment::get()->byID($reference);

        if (!$payment) {
            $this->setSessionMessage('Payment not found!', 'danger');
            return $this->redirect('https://attendantgh.com/cart');
        }

        $secretKey = Config::inst()->get('Paystack', 'secret_key');
        $client = new Client();

        try {
            $response = $client->request('GET', "https://api.paystack.co/transaction/verify/{$reference}", [
                'headers' => [
                    'Authorization' => "Bearer $secretKey"
                ],
                'verify' => true // Optional, for SSL certificate verification
            ]);

            $result = json_decode($response->getBody());

            if ($result->status && $result->data->status == 'success') {
                // Payment was successful, update the payment and order status
                $payment->Status = 'Paid';
                $payment->write();

                $order = $payment->Order();
                if ($order) {
                    $order->Status = 'Pending';
                    $order->write();
                }

                // Clear the cart after successful payment
                $cart = $this->getCart();
                if ($cart && $cart->CartItems()->exists()) {
                    $cart->CartItems()->removeAll();
                    $cart->delete();
                }

                $this->setSessionMessage('Payment successful!', 'success');
            } else {
                $this->setSessionMessage('Payment failed: ' . $result->data->gateway_response, 'danger');
            }
        } catch (RequestException $e) {
            $this->setSessionMessage('Payment failed: ' . $e->getMessage(), 'danger');
        }

        return $this->redirect('https://attendantgh.com/cart');
    }


    



    private function setSessionMessage($message, $type = 'success')
    {
        $session = $this->getRequest()->getSession();
        $session->set("Page.message", $message);
        $session->set("Page.messageType", $type);
    }
}