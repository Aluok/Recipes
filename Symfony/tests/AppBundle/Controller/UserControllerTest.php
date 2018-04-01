<?php

namespace Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
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
            array('en/me/recipes', 'My Recipes', '#main-container h1'),
            array('en/me/reviews', 'My Reviews', '#main-container h1'),
            //TODO Add a fixture to show a profile
        );
    }
}
