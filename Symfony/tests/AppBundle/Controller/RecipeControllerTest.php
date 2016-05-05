<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testRoutes($url, $text = null, $selector = null)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
        if ($text != null && $selector != null) {
            $this->assertContains($text, $crawler->filter($selector)->text());
        }
    }

    //---------------------Data providers-----------------------

    public function urlProvider()
    {
        return array(
            array('/recipe/list', 'Recipe list', '#main-container h1'),
            array('/reviews/list', 'Recipe list', '#main-container h1'),
            array('/recipe/new', 'Recipe creation', '#main-container h1'),
            array('/recipe/new/scratch'),
            array('/recipe/new/import'),
            //TODO Add a fixture for show, edit, delete, comment, review
        );
    }

    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/recipe/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(),
        "Unexpected HTTP status code for GET /recipe/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'AppBundle_recipe[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(),
        'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'AppBundle_recipe[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    */
}
