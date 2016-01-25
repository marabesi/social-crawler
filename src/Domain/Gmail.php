<?php

namespace SocialCrawler\Domain;

class Gmail extends Email
{

    /**
     * @return string the domain of a given email (eg: gmail.com)
     */
    public function getDomain()
    {
        return 'gmail\.com';
    }
}
