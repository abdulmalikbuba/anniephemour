<?php

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class BookPage extends Page
{
    private static $has_many = [
        'Books' => Book::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Books', GridField::create(
            'Books',
            'Books on this page',
            $this->Books(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }


}