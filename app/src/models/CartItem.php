<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

class CartItem extends DataObject
{
    private static $db = [
        'Quantity' => 'Int',
    ];

    private static $table_name = 'CartItem';

    private static $has_one = [
        'Cart' => Cart::class,
        'Book' => Book::class,
    ];

    public function TotalPrice()
    {
        if ($this->Book()->exists()) {
            return $this->Book()->Price * $this->Quantity;
        }
        return 0;
    }
    
    public static function hasPurchasedBook(Member $member, $bookID)
    {
        $cartItems = CartItem::get()->filter([
            'BookID' => $bookID,
            'Cart.MemberID' => $member->ID,
        ]);

        return $cartItems->exists();
    }
}
