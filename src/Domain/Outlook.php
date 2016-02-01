<?php

namespace SocialCrawler\Domain;

class Outlook extends Email
{

    /**
     * {@inheritdoc}
     */
    public function getDomain()
    {
        return 'outlook\.com';
    }
}