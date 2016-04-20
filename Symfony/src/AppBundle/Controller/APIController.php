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
	 * @Route("/api/list/{action}/{sorter}/{page}/{categories}", name="recipe_api_list",
	 * 		defaults={"sorter": "date", "page": 1, "categories": "All"},
     * 		requirements={"action": "recipe|review", 
     * 			"sorter": "date|title|category|duration|rating", "page": "\d+", "categories": ".*"})
	 * @Method("GET")
	 */
	public function listAction($action, $sorter, $page, $categories) {
		$em = $this->getDoctrine()->getManager();
		
		if ($action == "recipe") {
			$recipes = $em->getRepository('AppBundle:Recipe')->getListPublished(ListUtils::getCategoriesFilters($categories));
		} else if ($action == "review") {
			$recipes = $em->getRepository('AppBundle:Recipe')->getListForReview(ListUtils::getCategoriesFilters($categories));
		}
		
		switch ($sorter) {
			case 'date':
				ListUtils::objSort($recipes, 'getDateTimestamp', SORT_DESC);
				break;
			case 'rating':
				ListUtils::objSort($recipes, 'getRating', SORT_DESC);
				break;
			case 'title':
				ListUtils::objSort($recipes, 'getTitle', SORT_ASC);
				break;
			case 'category':
				ListUtils::objSort($recipes, 'getCategory', SORT_ASC);
				break;
			case 'duration':
				ListUtils::objSort($recipes, 'getDurationTimestamp', SORT_DESC);
				break;
		}
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