<?php

namespace SocialCrawler\Exception;

class EmptySetException extends \Exception
{

    public function __construct($message)
    {
        parent::__construct("couldn't find $message");
    }
}
