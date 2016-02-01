<?php

namespace SocialCrawler\Domain;

use GoogleUrl\GooglePosition;
use SocialCrawler\Domain\Source\Sourceable;
use SocialCrawler\Log\MonologFactory;

class Container implements Search
{
    /**
     * @var \GoogleUrl The search engine to be used
     */
    private $engineSearch;

    /**
     * @var int register per page to show
     */
    private $perPage;

    /**
     * @var \GoogleUrl\GooglePosition Holds the data fetched from engine search
     */
    private $resultSet;

    /**
     * @var \SocialCrawler\Domain\Source\Sourceable
     */
    private $source;

    /**
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * Container constructor.
     * @param \GoogleUrl $engineSearch
     * @param \SocialCrawler\Domain\Source\Sourceable $source
     */
    public function __construct(\GoogleUrl $engineSearch, Sourceable $source)
    {
        $this->engineSearch = $engineSearch;
        $this->source = $source;
    }

    /**
     * @return register
     */
    public function getPerPage()
    {
        if (null === $this->perPage) {
            $this->perPage = 10;
        }

        return $this->perPage;
    }

    /**
     * @param register $perPage
     * @return Container
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * @param int $type info, debug, error etc
     * @return \Monolog\Logger
     */
    public function getLogger($type = null)
    {
        if (null === $this->logger) {
            $this->logger = (new MonologFactory())->create();
        }

        return $this->logger;
    }

    /**
     * @param MonologFactory $logger
     * @return Container
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @param Email $email
     * @param int $page
     * @return $this
     * @throws \Exception
     * @throws \GoogleUrl\Exception\CaptachaException
     * @throws \GoogleUrl\Exception\CurlException
     * @throws \GoogleUrl\Exception\ProxyException
     */
    public function retrieveDataFromSource(Email $email, $page = 1)
    {
        if (empty($this->getPerPage())) {
            throw new \InvalidArgumentException('You must specify how many rows you want to see');
        }

        $this->engineSearch->setNumberResults(
            $this->getPerPage()
        );

        $this->engineSearch->setPage(
            $page - 1
        );

        $response = $this->engineSearch->search('INURL:' . $this->source->getName() . ' "@' . $email->getDomain() . '"');

        $this->resultSet = $response->getPositions();

        $this->getLogger()->addInfo(
            var_export($this->resultSet, true)
        );

        return $this;
    }

    /**
     * @return \GoogleUrl\GooglePosition
     */
    public function getResultSet()
    {
        return $this->resultSet;
    }
}
