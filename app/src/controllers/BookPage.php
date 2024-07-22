<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\PaginatedList;

class BookPageController extends PageController
{
    private static $allowed_actions = [];

    public function index(HTTPRequest $request)
    {
        $books = Book::get()->sort('Created','ASC');

        $pagination = new PaginatedList($books, $request);

        return $this->customise([
            'Books' => $pagination->setPageLength(8),
        ]);
    }

    public function getSessionMessage()
    {
        $session = $this->getRequest()->getSession();
        $message = $session->get('SessionMessage');
        $messageType = $session->get('SessionMessageType');
        $session->clear('SessionMessage');
        $session->clear('SessionMessageType');
        return [
            'Message' => $message,
            'Type' => $messageType,
        ];
    }

}