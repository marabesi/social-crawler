<?php

namespace Test;

use SocialCrawler\Domain\Container;
use SocialCrawler\Domain\Factory;
use SocialCrawler\Domain\Gmail;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    const PER_PAGE = 15;
    private $engine;
    private $source;

    public function setUp()
    {
        $this->engine = $this->getMock('\GoogleUrl');
        $this->source = $this->getMock('SocialCrawler\Domain\Source\Sourceable');
    }

    public function testShouldDefinePaginationLimit()
    {
        $container = new Container($this->engine, $this->source);

        $this->assertInstanceOf('SocialCrawler\Domain\Container', $container->setPerPage(15));
        $this->assertEquals(15, $container->getPerPage());
    }

    public function testShouldRetrieveEmailsFromSource()
    {
        $email = $this->getMockForAbstractClass('SocialCrawler\Domain\Email');
        $email->expects($this->once())
            ->method('getDomain');

        $result = $this->getMockBuilder('GoogleUrl\GooglePosition')
            ->disableOriginalConstructor()
            ->getMock();

        $proxy = $this->getMockBuilder('GoogleUrl\GoogleDOM')
            ->disableOriginalConstructor()
            ->getMock();
        $proxy->expects($this->once())
            ->method('getPositions')
            ->will($this->returnValue($result));

        $this->engine->expects($this->once())
            ->method('search')
            ->will($this->returnValue($proxy));

        $container = new Container($this->engine, $this->source);
        $container->setPerPage(self::PER_PAGE);

        $data = $container->retrieveDataFromSource($email);

        $this->assertInstanceOf('SocialCrawler\Domain\Container', $data);
    }

    public function testShouldDefineTotalPerPageByDefault()
    {
        $container = new Container($this->engine, $this->source);
        $this->assertEquals(10, $container->getPerPage());
    }
}