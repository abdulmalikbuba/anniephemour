<?php


use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;

class Book extends DataObject
{
    private static $db = [
        'Title' => 'Varchar(255)',
        'Description' => 'Text',
        'Price' => 'Currency',
        'Featured' => 'Boolean'
    ];

    private static $table_name = 'Book';

    private static $has_one = [
        'BookImage' => Image::class,
        'BookFile' => File::class,
        'BookPage' => BookPage::class,
    ];

    private static $has_many = [
        'OrderItems' => OrderItem::class
    ];

    private static $owns = [
        'BookImage',
        'BookFile',
    ];

    private static $summary_fields = [
        'Thumbnail' => 'Image',
        'Title' => 'Title',
        'Description' => 'Description',
        'Price.Nice' => 'Price',
        'Featured.Nice' => 'Featured'
    ];

    public function getThumbnail()
    {
        if ($this->BookImage()->exists()) {
            return $this->BookImage()->CMSThumbnail();
        }
        return '(No Image)';
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', TextField::create('Title', 'Title'));
        $fields->addFieldToTab('Root.Main', TextareaField::create('Description', 'Description'));
        $fields->addFieldToTab('Root.Main', CurrencyField::create('Price', 'Price'));
        $fields->addFieldToTab('Root.Main', $upload = UploadField::create('BookImage', 'Book Image'));
        $fields->addFieldToTab('Root.Main', $uploadFile = UploadField::create('BookFile', 'Book File'));
        $fields->addFieldToTab('Root.Main', CheckboxField::create('Featured', 'Featured'));

        $upload->setFolderName('BookImages');
        $uploadFile->setFolderName('BookFiles');

        return $fields;
    }

    public function canView($member = null)
    {
        return true;
    }

    public function canCreate($member = null, $context = [])
    {
        return true;
    }

    public function canEdit($member = null)
    {
        return true;
    }

    public function canDelete($member = null)
    {
        return true;
    }

}