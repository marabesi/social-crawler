<?php

namespace SocialCrawler\Domain;

use SocialCrawler\Exception\EmptySetException;

abstract class Email {

    const GMAIL   = 1;
    const OUTLOOK = 2;

    /**
     * @return string the domain of a given email (eg: gmail.com)
     */
    public abstract function getDomain();

    /**
     * Apply the rule throught a set rule and return only the email (eg: xx.ggl@domain.com)
     * @param string $text the text to search for
     * @throws \SocialCrawler\Exception\EmptySetException
     * @return string
     */
    public function find($text)
    {
        $pattern ='/^[A-Z0-9._%-]+@' . $this->getDomain() . '?\s/i';

        $clean = str_replace(
            ['(', ')', ' ...'],
            '',
            $text
        );

        $find = preg_match(
            $pattern,
            $clean,
            $matches
        );

        if ($find) {
            return trim($matches[0]);
        }

        throw new EmptySetException($clean);
    }
}
