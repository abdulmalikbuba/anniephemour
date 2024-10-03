<?php

use SilverStripe\ORM\DataObject;

class NewsletterSubscription extends DataObject
{
    private static $db = [
        'Email' => 'Varchar(255)'
    ];

    private static $table_name = 'NewsletterSubscription';

    private static $summary_fields = [
        'Email' => 'Email'
    ];
}
