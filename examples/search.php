<?php

require '../vendor/autoload.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$total = isset($_GET['total']) ? $_GET['total'] : 10;

$factory = new \SocialCrawler\Domain\Factory();
$email = $factory->create(\SocialCrawler\Domain\Outlook::OUTLOOK);

$source =  new \SocialCrawler\Domain\Source\Instagram();

$engine = new \GoogleUrl();
$search = new \SocialCrawler\Domain\Container($engine, $source);

$search->setPerPage($total);

$result = $search->retrieveDataFromSource($email, $page)
    ->getResultSet();

foreach ($result as $object) {
    try {
        print $email->find($object->getTitle()) . '<br/>';
    } catch (\Exception $exception) {
        //print "Couldn't find email in the object in the title ({$object->getTitle()}) <br/>";
    } finally {
        try {
           print $email->find($object->getSnippet()) . '<br/>';
        } catch (\Exception $exception) {
            //print "Couldn't find email in the object in the snippet ({$object->getSnippet()}) <br/>";
        }
    }
}
