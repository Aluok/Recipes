<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="recipe_home")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $best_authors = $em->getRepository('AppBundle:User')->find5best();
        $best_recipes = $em->getRepository('AppBundle:Recipe')->find5bestRated();
        $most_viewed_recipe = $em->getRepository('AppBundle:Recipe')->find5mostViewed();
        return $this->render('AppBundle:Default:index.html.twig', array(
            'best_authors' => $best_authors,
            'best_recipes' => $best_recipes,
            'most_viewed_recipe' => $most_viewed_recipe,
        ));
    }

    public function listRecipesAction($sorter) {
      return $this->render('AppBundle:Recipes:list.html.twig');
    }

    public function viewRecipeAction()
    {
        return $this->render('AppBundle:Recipes:recipe.html.twig');
    }
}
