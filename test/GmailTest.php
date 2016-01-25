<?php

namespace Test;

use SocialCrawler\Domain\Email;
use SocialCrawler\Domain\Factory;
use SocialCrawler\Exception\EmptySetException;

class GmailTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider resultProvider
     */
    public function testExtractGmaiAddresslFromInstagram($key, $title)
    {
        $expected = [
            "galinka.mirgaeva@gmail.com",
            "mononoeil@gmail.com",
            "renatameins@gmail.com",
            "restovskithereal@gmail.com",
            "Foodstockholm@gmail.com",
            "rebelfashionstyle@gmail.com",
            "amandabuccifit@gmail.com",
            "thisiswallysemail@gmail.com",
        ];

        $factory = new Factory();
        $email = $factory->create(Email::GMAIL);

        $this->assertEquals($expected[$key], $email->find($title));
    }

    /**
     * @dataProvider resultWithOutEmail
     * @expectedException \SocialCrawler\Exception\EmptySetException
     */
    public function testShouldNotFindAemail($title)
    {
        $factory = new Factory();
        $email = $factory->create(Email::GMAIL);

        $email->find($title);
    }

    public function testShouldFindEmailInSnippet()
    {
        $factory = new Factory();
        $email = $factory->create(Email::GMAIL);

        $snippet = strip_tags(file_get_contents('test/snippet.txt'));

        $this->assertEquals('bootyoptics@gmail.com', $email->find($snippet));
    }

    public function resultWithOutEmail()
    {
        return array(
            array("Dogs of Instagram (@dogsofinstagram) â¢ Instagram photos ..."),
            array("MARYANA RO (@maryana__ro) â¢ Instagram photos and ..."),
        );
    }

    public function resultProvider() {
        return array(
            array(0, "galinka.mirgaeva@gmail.com (@mirgaeva_galinka ..."),
            array(1, "mononoeil@gmail.com (@mononoeil) Instagram photos ..."),
            array(2, "renatameins@gmail.com (@renatameins) â¢ Instagram ..."),
            array(3, "restovskithereal@gmail.com (@restovski) â¢ Instagram ..."),
            array(4, "Foodstockholm@gmail.com (@stockholmfood) â¢ Instagram ..."),
            array(5, "rebelfashionstyle@gmail.com ... - Instagram"),
            array(6, "amandabuccifit@gmail.com (@amandabuccifit) â¢ Instagram ..."),
            array(7, "thisiswallysemail@gmail.com (@wally_and_molly ..."),
        );
    }
}
