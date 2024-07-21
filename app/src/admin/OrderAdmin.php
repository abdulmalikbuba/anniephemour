<?php

use SilverStripe\Admin\ModelAdmin;

class OrderAdmin extends ModelAdmin
{
    private static $managed_models = [
        Order::class,
        OrderItem::class,
        Payment::class
    ];

    private static $url_segment = 'orders';
    private static $menu_title = 'Orders';

    public function getExportFields()
    {
        return [
            'Order.ID' => 'Order ID',
            'Order.TotalPrice' => 'Total Price',
            'Order.Status' => 'Status',
            'Order.Created' => 'Order Date',
            'Order.Member.FirstName' => 'Customer First Name',
            'Order.Member.Surname' => 'Customer Surname',
            'Order.Member.PhoneNumber' => 'Customer Phone Number',
            'Order.Payment.Amount' => 'Payment Amount',
            'Order.Payment.Status' => 'Payment Status'
        ];
    }
}
