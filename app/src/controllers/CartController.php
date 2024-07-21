<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Security;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\ValidationException;
use SilverStripe\View\Requirements;

class CartController extends PageController
{
    private static $allowed_actions = [
        'addToCart',
        'removeFromCart',
        'updateQuantity',
        'purchase'
    ];


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

    // public function purchase(HTTPRequest $request)
    // {
    //     $member = Security::getCurrentUser();
    //     if (!$member) {
    //         $this->setSessionMessage('You must be logged in to purchase items!', 'danger');
    //         return $this->redirectBack();
    //     }

    //     $bookID = $request->postVar('BookID');
    //     if ($bookID) {
    //         // Single book purchase
    //         $book = Book::get()->byID($bookID);
    //         if (!$book) {
    //             $this->setSessionMessage('Book not found!', 'danger');
    //             return $this->redirectBack();
    //         }

    //         // Create a new cart for the single purchase
    //         $cart = Cart::create(['MemberID' => $member->ID]);
    //         $cart->write();

    //         // Add the book to the cart
    //         $cartItem = CartItem::create([
    //             'BookID' => $bookID,
    //             'Quantity' => 1,
    //             'TotalPrice' => $book->Price,
    //             'CartID' => $cart->ID
    //         ]);
    //         $cartItem->write();

    //         // Here you would typically handle the payment and order processing logic
    //         // For example, create an Order record, send confirmation email, etc.
    //         // Assuming a simplified payment process:
    //         $payment = Payment::create([
    //             'MemberID' => $member->ID,
    //             'Amount' => $cartItem->TotalPrice,
    //             'Status' => 'Completed'
    //         ]);
    //         $payment->write();

    //         // After successful payment, clear the cart
    //         $cart->delete();
    //     } else {
    //         // Regular cart purchase
    //         $cart = $this->getCart();
    //         if (!$cart || !$cart->CartItems()->exists()) {
    //             $this->setSessionMessage('Your cart is empty!', 'danger');
    //             return $this->redirectBack();
    //         }

    //         // Calculate total price
    //         $totalPrice = 0;
    //         foreach ($cart->CartItems() as $item) {
    //             $totalPrice += $item->TotalPrice;
    //         }

    //         // Here you would typically handle the payment and order processing logic
    //         // For example, create an Order record, send confirmation email, etc.
    //         // Assuming a simplified payment process:
    //         $payment = Payment::create([
    //             'MemberID' => $member->ID,
    //             'Amount' => $totalPrice,
    //             'Status' => 'Completed'
    //         ]);
    //         $payment->write();

    //         // After successful payment, clear the cart
    //         $cart->CartItems()->removeAll();
    //         $cart->delete();
    //     }

    //     // Assume payment and order processing are successful
    //     $this->setSessionMessage('Purchase completed successfully!', 'success');
    //     return $this->redirectBack();
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

        // Clear the cart after purchase
        $cart->CartItems()->removeAll();
        $cart->delete();

        $this->setSessionMessage('Purchase completed successfully!', 'success');
        return $this->redirectBack();
    }



    private function setSessionMessage($message, $type = 'success')
    {
        $session = $this->getRequest()->getSession();
        $session->set("Page.message", $message);
        $session->set("Page.messageType", $type);
    }
}