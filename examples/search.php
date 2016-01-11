<?php

require '../vendor/autoload.php';

$email = (new \SocialCrawler\Domain\Gmail());
$source =  new \SocialCrawler\Domain\Source\Instagram();

$engine = new \GoogleUrl();
$search = new \SocialCrawler\Domain\Container($engine, $source);

$search->setPerPage(10);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$total = isset($_GET['total']) ? $_GET['total'] : 10;

$result = $search->retrieveDataFromSource($email, $page)
    ->getResultSet();

$factory = new \SocialCrawler\Domain\Factory();
$gmail = $factory->create(\SocialCrawler\Domain\Gmail::GMAIL);

foreach ($result as $object) {
    try {
        print $gmail->find($object->getTitle()) . '<br/>';
    } catch (\Exception $exception) {
        print "Couldn't find email in the object <br/>";
    }
}
