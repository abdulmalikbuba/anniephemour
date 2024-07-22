<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\PaginatedList;

class BookClubPageController extends PageController
{
    private static $allowed_actions = [
        'detail',
    ];

    public function index(HTTPRequest $request)
    {
        $bookreadings = BookReadingEvent::get()->sort('Created','DESC');

        $pagination = new PaginatedList($bookreadings, $request);

        return $this->customise([
            'BookReadingEvents' => $pagination->setPageLength(9),
        ]);
    }

    public function detail(HTTPRequest $request)
    {
        $id = $request->param("ID");

        $detail = BookReadingEvent::get()->byID($id);
        
        return $this->customise([
            'Title' => 'Detail Page',
            'BookClubDetail' => $detail
        ])->renderWith(['BookClubDetailPage','Page']);
    }
}