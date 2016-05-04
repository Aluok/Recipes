<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
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
            array('/me/recipes', 'My Recipes', '#main-container h1'),
            array('/me/reviews', 'My Reviews', '#main-container h1'),
            //TODO Add a fixture to show a profile
        );
    }
}
