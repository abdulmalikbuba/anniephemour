<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

class PodcastEpisode extends DataObject
{
    private static $db = [
        'Title' => 'Varchar(255)',
        'Description' => 'Text',
        'ReleaseDate' => 'Datetime',
    ];

    private static $has_one = [
        'AudioFile' => File::class,
        'Podcast' => Podcast::class,
    ];

    private static $owns = [
        'AudioFile',
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'ReleaseDate.Nice' => 'Release Date',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', TextField::create('Title', 'Title'));
        $fields->addFieldToTab('Root.Main', TextareaField::create('Description', 'Description'));
        $fields->addFieldToTab('Root.Main', DatetimeField::create('ReleaseDate', 'Release Date'));
        $fields->addFieldToTab('Root.Main', UploadField::create('AudioFile', 'Audio File'));

        return $fields;
    }
}