<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\CheckboxSetField; // Use CheckboxSetField instead of DropdownField
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\HasManyList;

class HomePage extends Page
{
    private static $db = [
        'WelcomeTitle' => 'Varchar(255)',
        'WelcomeContent' => 'Text',
        'AboutTitle' => 'Varchar(255)',
        'AboutContent' => 'Text',
        'BookTitle' => 'Varchar(255)',
        'BookSubTitle' => 'Text',
    ];

    private static $has_one = [
        'BannerImage' => Image::class,
        'AboutImage' => Image::class,
    ];

    private static $has_many = [
        'Books' => Book::class,
    ];

    private static $owns = [
        'BannerImage',
        'AboutImage',
    ];


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab('Root.WelcomeSection', [
            TextField::create('WelcomeTitle', 'Heading'),
            TextareaField::create('WelcomeContent', 'Content'),
            UploadField::create('BannerImage', 'Banner Image')
                ->setFolderName('Home page images')
                ->setAllowedExtensions(['png', 'gif', 'jpeg', 'jpg', 'tiff'])
        ]);

        $fields->addFieldsToTab('Root.AboutSection', [
            TextField::create('AboutTitle', 'Heading'),
            TextareaField::create('AboutContent', 'Content'),
            UploadField::create('AboutImage', 'About Image')
                ->setFolderName('About section images')
                ->setAllowedExtensions(['png', 'gif', 'jpeg', 'jpg', 'tiff'])
        ]);

        $fields->addFieldsToTab('Root.BookSection', [
            TextField::create('BookTitle', 'Heading'),
            TextareaField::create('BookSubTitle', 'Description'),
        ]);


        return $fields;
    }

    public function getFeaturedBooks()
    {
        return $this->Books()->filter('Featured', true);
    }
}