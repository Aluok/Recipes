<?php

namespace RecipeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RecipeBundle:Default:index.html.twig');
    }

    public function listRecipesAction($sorter) {
      return $this->render('RecipeBundle:Recipes:list.html.twig');
    }

    public function viewRecipeAction()
    {
        return $this->render('RecipeBundle:Recipes:recipe.html.twig');
    }
}
