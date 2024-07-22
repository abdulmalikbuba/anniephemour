<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class BookClubPage extends Page
{
    private static $has_many = [
        'BookReadingEvents' => BookReadingEvent::class,
    ];

    private static $table_name = 'BookClubPage';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $eventGridField = GridField::create(
            'BookReadingEvents',
            'Book Reading Events',
            $this->BookReadingEvents(),
            GridFieldConfig_RecordEditor::create()
        );

        $fields->addFieldToTab('Root.BookReadingEvents', $eventGridField);

        return $fields;
    }
}
