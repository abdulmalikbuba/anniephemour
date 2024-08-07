<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

class Payment extends DataObject
{
    private static $db = [
        'Amount' => 'Currency',
        'Status' => 'Enum(array("Pending", "Paid", "Failed"))'
    ];

    private static $has_one = [
        'Member' => Member::class,
        'Order' => Order::class
    ];

    private static $summary_fields = [
        'Amount' => 'Amount',
        'Status' => 'Status',
        'Created' => 'Date',
    ];

    private static $default_sort = 'Created DESC';

    private static $table_name = 'Payment';

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
