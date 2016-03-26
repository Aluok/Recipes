<?php

namespace RecipeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $best_authors = $em->getRepository('RecipeBundle:User')->find5best();
        return $this->render('RecipeBundle:Default:index.html.twig', array(
            'best_authors' => $best_authors,

        ));
    }

    public function listRecipesAction($sorter) {
      return $this->render('RecipeBundle:Recipes:list.html.twig');
    }

    public function viewRecipeAction()
    {
        return $this->render('RecipeBundle:Recipes:recipe.html.twig');
    }
}
