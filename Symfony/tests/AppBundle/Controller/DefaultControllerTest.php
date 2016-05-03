<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
     //TODO adds a selector and an element to check whether it is the right page
    public function testRoutes($url, $text, $selector)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains($text, $crawler->filter($selector)->text());
    }

    //---------------------Data providers-----------------------

    public function urlProvider()
    {
        return array(
            array('/', 'Julien\'s Recipe', '#main-container h1'),
        );
    }
}
