<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;

class SiteConfigExtension extends DataExtension
{
    private static $db = [
        'FacebookLink' => 'Varchar(255)',
        'TwitterLink' => 'Varchar(255)',
        'InstagramLink' => 'Varchar(255)',
        'TikTokLink' => 'Varchar(255)',
        'EmailAddress' => 'Varchar(255)',
        'PhoneNumber' => 'Varchar',
    ];

    private static $has_one = [
        'FrontEndBranding' => Image::class
    ];

    private static $owns = [
        'FrontEndBranding',
        'FooterBranding',
    ];

    public function updateCMSFields(FieldList $fields)
    {

        $fields->addFieldsToTab('Root.SocialMedia', array(
            TextField::create('FacebookLink', 'Facebook'),
            TextField::create('InstagramLink', 'Instagram'),
            TextField::create('TikTokLink', 'TikTok'),
            TextField::create('TwitterLink', 'Twitter'),
        ));

        $fields->addFieldsToTab('Root.ContactUs', array(
            TextField::create('EmailAddress', 'Email Address'),
            TextField::create('PhoneNumber','Phone Number'),
        ));


        $fields->addFieldToTab('Root.FrontEndBranding', $upload = UploadField::create('FrontEndBranding', 'Logo'));

        // $upload->getValidator()->setAllowedExtensions(array(
        //     'png', 'jpeg', 'jpg', 'gif'
        // ));

        $upload->setFolderName('front-end-logo');


        $fields->addFieldToTab('Root.FooterBranding', $FooterBranding = UploadField::create('FooterBranding', 'Logo'));

        $FooterBranding->getValidator()->setAllowedExtensions(array(
            'png', 'jpeg', 'jpg', 'gif'
        ));

        $FooterBranding->setFolderName('Footer-logo');
    }
}