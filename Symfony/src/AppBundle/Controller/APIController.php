<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Utils\ListUtils;

class APIController extends Controller
{
    /**
     * @Route("/api/list/{action}/{sorter}/{page}/{direction}/{categories}", name="recipe_api_list",
     *      defaults={"sorter": "date", "page": 1, "categories": "All", "direction": "ASC"},
     *      requirements={"action": "recipe|review",
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
        $em = $this->getDoctrine()->getManager();
        if ($action == 'recipe') {
            $method = 'getListPublished';
        } elseif ($action == 'review') {
            $method = 'getListForReview';
        }
        $recipes = $em
            ->getRepository('AppBundle:Recipe')
            ->$method(
                ListUtils::getCategoriesFilters($categories),
                $page,
                $sorter,
                $direction
            );
        return new JsonResponse($this->generateJSONResponse($recipes));
    }

    private function generateJSONResponse($recipes)
    {
        $recipes_sent = array();
        foreach ($recipes as $recipe) {
            $recipes_sent[] = array(
                'title' => $recipe->getTitle(),
                'slug' => $recipe->getSlug(),
                'category' => $recipe->getCategory(),
                'duration' => $recipe->getDuration(),
                'rating' => $recipe->getRating(),
            );
        }
        return array('recipes' => $recipes_sent);
    }
}
