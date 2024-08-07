<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class FanzonePhotos extends DataObject
{
    private static $db = [];

    private static $has_one = [
        "Photo"=> Image::class,
        "Fanzone" => Fanzone::class
    ];

    private static $table_name = "Fanzonephotos";

    private static $owns = [
        'Photo'
    ];

    private static $summary_fields = [
        'Thumbnail' => 'Thumbnail',
    ];

    public function getThumbnail() {
        return $this->Photo()->CMSThumbnail();
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab(
            'Root.Main', 
            $upload = UploadField::create('Photo', 'Photo')
            ->setIsMultiUpload(true)
        );

        $upload->setFolderName('Fanzone Photos');

        return $fields;
    }
    
}