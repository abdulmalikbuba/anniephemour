<?php

use SilverStripe\ORM\DataExtension;

class MemberExtension extends DataExtension
{
    private static $db = [
        'PhoneNumber' => 'Varchar',
    ];

}