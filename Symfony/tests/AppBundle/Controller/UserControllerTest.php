<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
     //TODO adds a selector and an element to check whether it is the right page
    public function testRoutes($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    //---------------------Data providers-----------------------

    public function urlProvider()
    {
        return array(
            array('/me/recipes'),
            array('/me/ratings'),
            array('/me/reviews'),
            //TODO Add a fixture to show a profile
        );
    }
}
