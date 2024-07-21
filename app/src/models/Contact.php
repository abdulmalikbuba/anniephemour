<?php

use SilverStripe\ORM\DataObject;

class ContactSubmission extends DataObject
{
    private static $db = [
        'Name' => 'Varchar(255)',
        'Email' => 'Varchar(255)',
        'Subject' => 'Varchar(255)',
        'Message' => 'Text',
    ];
}