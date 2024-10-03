<?php


use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

class Order extends DataObject
{
    private static $db = [
        'TotalPrice' => 'Currency',
        'Status' => 'Enum(array("Pending", "Processing", "Completed", "Cancelled"), "Pending")'
    ];

    private static $has_one = [
        'Member' => Member::class,
        'Payment' => Payment::class
    ];

    private static $has_many = [
        'OrderItems' => OrderItem::class
    ];

    private static $summary_fields = [
        'ID' => 'Order ID',
        'Member.FirstName' => 'Customer First Name',
        'Member.Surname' => 'Customer Surname',
        // 'Member.PhoneNumber' => 'Customer Phone Number',
        'Status' => 'Order Status',
        'TotalPrice' => 'Total Price',
        'Payment.Status' => 'Payment Status',
        'Created' => 'Order Date'
    ];

    private static $default_sort = 'Created DESC';

    private static $table_name = 'Order';

    public function canView($member = null)
    {
        return true;
    }

    public function canCreate($member = null, $context = [])
    {
        return true;
    }

    public function canEdit($member = null)
    {
        return true;
    }

    public function canDelete($member = null)
    {
        return true;
    }

}