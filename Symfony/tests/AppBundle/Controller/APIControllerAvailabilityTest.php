<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class APIControllerAvailabilityTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testRoutes($url)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $response = $client->getResponse();
        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $this->assertContains('"totalPages":', $response->getContent());
        $this->assertContains('"recipes":', $response->getContent());
    }

    //---------------------Data providers-----------------------

    public function urlProvider()
    {
        return array(
            array('en/api/list/recipe'),
            array('en/api/list/review'),
            //TODO Add a fixture for list
            array('fr/api/list/recipe'),
            array('fr/api/list/review'),
        );
    }
}
