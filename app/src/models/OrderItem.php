<?php


use SilverStripe\ORM\DataObject;

class OrderItem extends DataObject
{
    private static $db = [
        'Quantity' => 'Int',
        'TotalPrice' => 'Currency'
    ];

    private static $has_one = [
        'Order' => Order::class,
        'Book' => Book::class
    ];

    private static $summary_fields = [
        'Order.ID' => 'Order ID',
        'Book.Title' => 'Book Title',
        'Quantity' => 'Quantity',
        'TotalPrice' => 'Total Price'
    ];

    private static $default_sort = 'OrderID ASC';

    private static $table_name = 'OrderItem';

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        if ($this->Book()->exists()) {
            $this->TotalPrice = $this->Book()->Price * $this->Quantity;
        } else {
            $this->TotalPrice = 0;
        }
    }

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
