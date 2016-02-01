<?php

namespace SocialCrawler\Domain;

class Factory
{

    /**
     * @param $email
     * @return \SocialCrawler\Domain\Email
     */
    public function create($email)
    {
        switch ($email) {
            case Email::GMAIL :
                return new Gmail();
            case Email::OUTLOOK :
                return new Outlook();
        }
    }
}