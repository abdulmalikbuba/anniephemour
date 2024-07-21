<?php

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;

class HomePageController extends PageController
{
    private static $allowed_actions = [];

    public function FeaturedBooks()
    {
        $books = Book::get()->filter('Featured', true)->toArray();
        shuffle($books);
        return new ArrayList(array_slice($books, 0, 3));
    }
}
