<?php

use SilverStripe\Admin\LeftAndMainExtension;
use SilverStripe\View\Requirements;

class CMSBrandingExtension extends LeftAndMainExtension
{
    public function init()
    {
        parent::init();
        Requirements::css('app/css/admin-custom.css');
    }
}
