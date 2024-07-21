<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\ORM\FieldType\DBCurrency;

class Cart extends DataObject
{
    private static $db = [
        'SessionID' => 'Varchar(255)',
        'Total' => 'Currency',
    ];

    private static $table_name = 'Cart';

    private static $has_one = [
        'Member' => Member::class,
    ];

    private static $has_many = [
        'CartItems' => CartItem::class,
    ];

    private static $summary_fields = [
        'ID' => 'Cart ID',
        'Total.Nice' => 'Total',
    ];

    public function getTotal()
    {
        $total = 0;
        foreach ($this->CartItems() as $cartItem) {
            $total += $cartItem->TotalPrice();
        }
        return DBCurrency::create()->setValue($total);
    }
}
