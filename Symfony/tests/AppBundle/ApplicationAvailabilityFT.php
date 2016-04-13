<?php
// tests/AppBundle/ApplicationAvailabilityFunctionalTest.php
namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
    * @dataProvider urlProvider
    */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
    public function urlProvider()
    {
        return array(
            array('/'),
            array('/recipe/new'),
            //TODO add a way for show, comment, and review (fixture)
            array('/recipe/list/'),
            array('/reviews/list/'),
            array('/me/recipes'),
            array('/me/ratings'),
            array('/me/reviews'),
        );
    }
}
