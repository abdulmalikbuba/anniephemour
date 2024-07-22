<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\FieldList;

class EventPicture extends DataObject
{
    private static $has_one = [
        'BookReadingEvent' => BookReadingEvent::class,
        'Image' => Image::class,
    ];

    private static $owns = [
        'Image',
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Image',
    ];

    public function getCMSFields()
    {
        return FieldList::create(
            UploadField::create('Image', 'Event Picture')
        );
    }

    private static $table_name = 'EventPicture';
}
