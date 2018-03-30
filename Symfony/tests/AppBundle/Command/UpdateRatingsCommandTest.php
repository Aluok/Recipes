<?php
namespace Test\AppBundle\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

use AppBundle\Entity\Recipe;
use AppBundle\Command\UpdateRatingsCommand;

class UpdateRatingsCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getMockMethod
     */
    public function testExecute($mockMethod, $output)
    {
        $application = new Application();
        $application->add(new UpdateRatingsCommand());

        $command = $application->find('recipe:update:ratings');
        $command->setContainer($this->getMockContainer($mockMethod));

        $tester = new CommandTester($command);
        $tester->execute(
            array_merge(array('command' => $command->getName()))
        );

        if (count($output) == 0) {
            $this->assertEquals('', $tester->getDisplay());
        }
        for ($i=0; $i < count($output); $i++) {
            $this->assertContains($output[$i], $tester->getDisplay());
        }
    }

    private function getMockContainer($mockMethod)
    {
        //Create the mocks
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\Container')
            ->disableOriginalConstructor()
            ->getMock();
        $doctrine = $this->getMockBuilder('Doctrine\\Bundle\\DoctrineBundle\\Registry')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager = $this->getMockBuilder('Doctrine\\ORM\\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $repository = $this->getMockBuilder('AppBundle\\Repository\\RecipeRepository')
            ->disableOriginalConstructor()
            ->getMock();

        //Configure Mocks
        $container
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('doctrine'))
            ->will($this->returnValue($doctrine));
        $doctrine
            ->expects($this->once())
            ->method('getManager')
            ->will($this->returnValue($entityManager));
        $entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->with('AppBundle:Recipe')
            ->will($this->returnValue($repository));
        $repository
            ->expects($this->once())
            ->method('__call')
            ->with($this->anything())
            ->will($this->returnValue($this->$mockMethod()));

        return $container;
    }

    public function getRecipesEmpty()
    {
        return array();
    }

    public function getRecipesNoReview()
    {
        $recipeMock = $this->getMockBuilder('AppBundle\\Entity\\Recipe')
            ->disableOriginalConstructor()
            ->getMock();
        $recipeMock
            ->expects($this->once())
            ->method('getReviews')
            ->will($this->returnValue(array()));
        $recipeMock
            ->expects($this->once())
            ->method('setPublished')
            ->with($this->equalTo(false));
        $recipeMock
            ->expects($this->once())
            ->method('setRating')
            ->with(0);
        $recipeMock
            ->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('title'));
        return array($recipeMock);
    }

    public function getRecipesLessThan4Reviews()
    {
        $reviewMock = $this->getMockBuilder('AppBundle\\Entity\\Rating')
            ->disableOriginalConstructor()
            ->getMock();
        $reviewMock
            ->expects($this->exactly(2))
            ->method('getRating')
            ->will($this->returnValue(5));
        $recipeMock = $this->getMockBuilder('AppBundle\\Entity\\Recipe')
            ->disableOriginalConstructor()
            ->getMock();

        $recipeMock
            ->expects($this->once())
            ->method('getReviews')
            ->will($this->returnValue(array($reviewMock, $reviewMock)));
        $recipeMock
            ->expects($this->once())
            ->method('setPublished')
            ->with(false);
        $recipeMock
            ->expects($this->once())
            ->method('setRating')
            ->with(5);
        $recipeMock
            ->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('title'));
        return array($recipeMock);
    }

    public function getRecipesLessThan4ReviewsScoreEqual1()
    {
        $reviewMock = $this->getMockBuilder('AppBundle\\Entity\\Rating')
            ->disableOriginalConstructor()
            ->getMock();
        $reviewMock
            ->expects($this->exactly(2))
            ->method('getRating')
            ->will($this->returnValue(1));
        $recipeMock = $this->getMockBuilder('AppBundle\\Entity\\Recipe')
            ->disableOriginalConstructor()
            ->getMock();

        $recipeMock
            ->expects($this->once())
            ->method('getReviews')
            ->will($this->returnValue(array($reviewMock, $reviewMock)));
        $recipeMock
            ->expects($this->once())
            ->method('setPublished')
            ->with(false);
        $recipeMock
            ->expects($this->once())
            ->method('setRating')
            ->with(1);
        $recipeMock
            ->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('title'));
        return array($recipeMock);
    }

    public function getRecipes4ReviewsScoreEqual1()
    {
        $reviewMock = $this->getMockBuilder('AppBundle\\Entity\\Rating')
            ->disableOriginalConstructor()
            ->getMock();
        $reviewMock
            ->expects($this->exactly(4))
            ->method('getRating')
            ->will($this->returnValue(1));
        $recipeMock = $this->getMockBuilder('AppBundle\\Entity\\Recipe')
            ->disableOriginalConstructor()
            ->getMock();

        $recipeMock
            ->expects($this->once())
            ->method('getReviews')
            ->will($this->returnValue(array($reviewMock, $reviewMock, $reviewMock, $reviewMock)));
        $recipeMock
            ->expects($this->once())
            ->method('setPublished')
            ->with(false);
        $recipeMock
            ->expects($this->once())
            ->method('setRating')
            ->with(1);
        $recipeMock
            ->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('title'));
        return array($recipeMock);
    }

    public function getRecipesOK()
    {
        $reviewMock = $this->getMockBuilder('AppBundle\\Entity\\Rating')
            ->disableOriginalConstructor()
            ->getMock();
        $reviewMock
            ->expects($this->exactly(4))
            ->method('getRating')
            ->will($this->returnValue(5));
        $recipeMock = $this->getMockBuilder('AppBundle\\Entity\\Recipe')
            ->disableOriginalConstructor()
            ->getMock();

        $recipeMock
            ->expects($this->once())
            ->method('getReviews')
            ->will($this->returnValue(array($reviewMock, $reviewMock, $reviewMock, $reviewMock)));
        $recipeMock
            ->expects($this->once())
            ->method('setPublished')
            ->with(true);
        $recipeMock
            ->expects($this->once())
            ->method('setRating')
            ->with(5);
        $recipeMock
            ->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('title'));
        return array($recipeMock);
    }

    public function getRecipesForAverageCheck()
    {
        $reviewMock = $this->getMockBuilder('AppBundle\\Entity\\Rating')
            ->disableOriginalConstructor()
            ->getMock();

        $recipeMock = $this->getMockBuilder('AppBundle\\Entity\\Recipe')
            ->disableOriginalConstructor()
            ->getMock();

        $recipeMock
            ->expects($this->exactly(3))
            ->method('getReviews')
            ->will($this->returnValue(array($reviewMock, $reviewMock, $reviewMock, $reviewMock)));
        $recipeMock
            ->expects($this->exactly(3))
            ->method('setPublished')
            ->with(true);
        $recipeMock
            ->expects($this->exactly(3))
            ->method('setRating')
            ->withConsecutive(array(3.5), array(2.75), array(3.25));
        $recipeMock
            ->expects($this->exactly(3))
            ->method('getTitle')
            ->will($this->returnValue('title'));

        $reviewMock
            ->expects($this->exactly(12))
            ->method('getRating')
            ->will($this->onConsecutiveCalls(5, 4, 3, 2, 1, 2, 3, 5, 5, 5, 1, 2));
        return array($recipeMock, $recipeMock, $recipeMock);
    }

    public function getMockMethod()
    {
        return array(
            array('getRecipesEmpty', array()),
            array('getRecipesNoReview',  array('title : 0')),
            array('getRecipesLessThan4Reviews', array('title : 5')),
            array('getRecipesLessThan4ReviewsScoreEqual1', array('title : 1')),
            array('getRecipes4ReviewsScoreEqual1', array('title : 1')),
            array('getRecipesOK', array('title : 5')),
            array('getRecipesForAverageCheck', array('title : 3.5', 'title : 2.75', 'title : 3.25')),
        );
    }
}
