<?php

namespace SocialCrawler\Domain;

use GoogleUrl\GooglePosition;
use SocialCrawler\Domain\Source\Sourceable;

class Container implements Search
{
    /**
     * @var \GoogleUrl The search engine to be used
     */
    private $engineSearch;

    /**
     * @var $limit register per page to show
     */
    private $perPage;

    /**
     * @var $resultSet Holds the data fetched from engine search
     */
    private $resultSet;

    private $source;

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
            ($page - 1)
        );

        $response = $this->engineSearch->search('INURL:' . $this->source->getName() . ' "@' . $email->getDomain() . '"');

        $this->resultSet = $response->getPositions();

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
