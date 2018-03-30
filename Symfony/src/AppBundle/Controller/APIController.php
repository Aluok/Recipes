<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Utils\ListUtils;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\DataCollectorTranslator;

/**
 * @Route(service="app.controller.api")
 */
class APIController extends Controller
{
    private $em;
    private $translator;

    public function __construct(EntityManager $em, DataCollectorTranslator $trans)
    {
        $this->em = $em;
        $this->translator = $trans;
    }

    /**
     * @Route("/api/list/{action}/{sorter}/{page}/{direction}/{categories}", name="recipe_api_list",
     *      defaults={"sorter": "date", "page": 1, "categories": "All", "direction": "ASC"},
     *      requirements={
     *          "action": "recipe|review",
     *          "sorter": "date|title|category|duration|rating|views",
     *          "page": "\d+",
     *          "categories": ".*",
     *          "direction": "ASC|DESC"
     *      }
     * )
     * @Method("GET")
     */
    public function listAction($action, $sorter, $page, $categories, $direction)
    {
        if ($action == 'recipe') {
            $method = 'getListPublished';
        } elseif ($action == 'review') {
            $method = 'getListForReview';
        }
        $recipes = $this->em
            ->getRepository('AppBundle:Recipe')
            ->$method(
                ListUtils::getFilters($categories),
                $page,
                $sorter,
                $direction
            );
        $responseData = $this->generateJSONResponse($recipes);
        $responseData['totalPages'] = $this->em->getRepository('AppBundle:Recipe')->getCount(
            $action == 'recipe',
            ListUtils::getFilters($categories)
        );
        return new JsonResponse($responseData);
    }

    private function generateJSONResponse($recipes)
    {
        $recipes_sent = array();
        foreach ($recipes as $recipe) {
            $recipes_sent[] = array(
                'title' => $recipe->getTitle(),
                'slug' => $recipe->getSlug(),
                'category' => $this->translator->trans($recipe->getCategory(), array(), 'app'),
                'duration' => $recipe->getDuration(),
                'rating' => $recipe->getRating(),
                'languages' => array(
                    $recipe->getLanguage(),
                ),
                //TODO only one for the moment, should be able to group recipes with same slug
            );
        }
        return array('recipes' => $recipes_sent);
    }
}
