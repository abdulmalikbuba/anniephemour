<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;

class Fanzone extends Page
{
    private static $has_many = [
        'Photos' => FanzonePhotos::class
    ];

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $config = GridFieldConfig_RelationEditor::create();
        $photoField = GridField::create(
            'Photos',
            'Photos in this Fanzone',
            $this->Photos(),
            $config
        );
        $fields->addFieldToTab('Root.Photos', $photoField);
        return $fields;
    }
}