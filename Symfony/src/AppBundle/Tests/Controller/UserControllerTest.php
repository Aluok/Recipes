<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testRecipes()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/recipes');
    }

    public function testRatings()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ratings');
    }

    public function testReviews()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reviews');
    }

}
