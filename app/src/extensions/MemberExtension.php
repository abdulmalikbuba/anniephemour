<?php

use SilverStripe\ORM\DataExtension;

class MemberExtension extends DataExtension
{
    private static $db = [
        'PhoneNumber' => 'Varchar',
        'Address' => 'Varchar(255)'
    ];

}