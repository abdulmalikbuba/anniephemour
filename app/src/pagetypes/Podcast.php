<?php

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class Podcast extends Page
{
    private static $has_many = [
        'Episodes' => PodcastEpisode::class,
    ];

    private static $owns = [
        'Episodes',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $config = GridFieldConfig_RecordEditor::create();
        $episodesField = GridField::create(
            'Episodes',
            'Podcast Episodes',
            $this->Episodes(),
            $config
        );

        $fields->addFieldToTab('Root.Episodes', $episodesField);

        return $fields;
    }
}