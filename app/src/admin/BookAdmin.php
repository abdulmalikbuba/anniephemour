<?php

use SilverStripe\Admin\ModelAdmin;

class BookAdmin extends ModelAdmin
{
    private static $managed_models = [
        Book::class
    ];

    private static $url_segment = 'books';
    private static $menu_title = 'Books';

    private static $menu_icon_class = 'font-icon-book';

}