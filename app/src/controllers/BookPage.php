<?php

class BookPageController extends PageController
{
    private static $allowed_actions = [];

    public function getBooks()
    {
        return Book::get();
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