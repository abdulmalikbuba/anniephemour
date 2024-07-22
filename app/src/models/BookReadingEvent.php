<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class BookReadingEvent extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Date' => 'Date',
        'Description' => 'Text',
    ];

    private static $has_one = [
        'BookClubPage' => BookClubPage::class,
        'Flyer' => Image::class,
    ];

    private static $has_many = [
        'Pictures' => EventPicture::class,
    ];

    private static $owns = [
        'Flyer',
        'Pictures',
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Date.Nice' => 'Date',
        'Description' => 'Description',
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Title', 'Event Title'),
            DateField::create('Date', 'Event Date'),
            TextareaField::create('Description', 'Event Description'),
            UploadField::create('Flyer', 'Event Flyer'),
           
        );

        // GridField for managing EventPicture objects
        $picturesField = GridField::create(
            'Pictures',
            'Event Pictures',
            $this->Pictures(),
            GridFieldConfig_RecordEditor::create()
        );
        $fields->push($picturesField);

        return $fields;
    }

    private static $table_name = 'BookReadingEvent';

    public function Link()
    {
        return $this->BookClubPage()->Link('detail/' . $this->ID);
    }
}
