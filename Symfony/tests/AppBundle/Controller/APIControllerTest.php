<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class APIControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
     //TODO adds a selector and an element to check whether it is the right page
    public function testRoutes($url)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
        //TODO create a test on a JSON response
    }

    //---------------------Data providers-----------------------

    public function urlProvider()
    {
        return array(
            array('/api/list/recipe'),
            array('/api/list/review'),
            //TODO Add a fixture for list
        );
    }
}
