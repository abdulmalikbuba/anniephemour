<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;

class Photo extends DataObject {
    private static $db = [
        'Title' => 'Varchar',
        'Description' => 'Text'
    ];

    private static $has_one = [
        'Photo' => Image::class,
        'Fanzone' => Fanzone::class
    ];

    private static $owns = [
        'Photo'
    ];

    private static $summary_fields = [
        'Thumbnail' => 'Thumbnail',
        'Title' => 'Title',
        'Description' => 'Description'
    ];

    public function getThumbnail() {
        return $this->Photo()->CMSThumbnail();
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', UploadField::create('Photo', 'Photo'));
        return $fields;
    }
}