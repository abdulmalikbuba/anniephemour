<?php

class FanzoneController extends PageController
{
    public function index()
    {
        $photos = FanzonePhotos::get()->sort('Created','ASC');

        return $this->customise([
            'Photos' => $photos,
        ]);
    }
}