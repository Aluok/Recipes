<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Controller\APIController;
use AppBundle\Utils\ListUtils;

class APIControllerTest extends WebTestCase
{
    protected $repository;
    protected $entityManager;
    protected $recipeMock;

    public function setUp()
    {
        //Create the Mocks
        $this->repository = $this->getMockBuilder('AppBundle\\Repository\\RecipeRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $this->entityManager = $this->getMockBuilder('Doctrine\\ORM\\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $this->recipeMock = $this->getMockBuilder('AppBundle\\Entity\\Recipe')
            ->disableOriginalConstructor()
            ->getMock();

        //Set the methods
        $this->entityManager
            ->expects($this->exactly(2))
            ->method('getRepository')
            ->with($this->equalTo('AppBundle:Recipe'))
            ->will($this->returnValue($this->repository));
        $this->recipeMock
            ->expects($this->exactly(3))
            ->method('getTitle');
        $this->recipeMock
            ->expects($this->exactly(3))
            ->method('getSlug');
        $this->recipeMock
            ->expects($this->exactly(3))
            ->method('getCategory');
        $this->recipeMock
            ->expects($this->exactly(3))
            ->method('getDuration');
        $this->recipeMock
            ->expects($this->exactly(3))
            ->method('getRating');
    }

    /**
     * @dataProvider actionParametersProvider
     */
    public function testRecipeList($action, $sorter, $page, $categories, $direction, $method)
    {
        //Set the vars
        $recipes_data = array($this->recipeMock, $this->recipeMock, $this->recipeMock);

        //Set the Repository Mock
        $this->repository
            ->expects($this->once())
            ->method($method)
            ->with(
                $this->equalTo(ListUtils::getFilters($categories)),
                $this->equalTo($page),
                $this->equalTo($sorter),
                $this->equalTo($direction)
            )
            ->will($this->returnValue($recipes_data));
        $this->repository
            ->expects($this->once())
            ->method('getCount')
            ->with(
                $this->equalTo($action == 'recipe'),
                $this->equalTo(ListUtils::getFilters($categories))
            )
            ->will($this->returnValue(5));

        $controller = new APIController($this->entityManager);
        $response = $controller->listAction($action, $sorter, $page, $categories, $direction);
        $this->assertRegExp('/^{"recipes":\[{.*},{.*},{.*}\],"totalPages":5}$/', $response->getContent());

    }

    public function actionParametersProvider()
    {
        return array(
            array('recipe', 'date', 1, 'All', 'ASC', 'getListPublished'),
            array('review', 'date', 1, 'All', 'ASC', 'getListForReview')
        );
    }
}
