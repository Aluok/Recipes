<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\User;
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
        $best_authors = $em->getRepository(User::class)->find5best();
        $best_recipes = $em->getRepository(Recipe::class)->find5bestRated();
        $most_viewed_recipe = $em->getRepository(Recipe::class)->find5mostViewed();
        return $this->render('Default/index.html.twig', array(
            'best_authors' => $best_authors,
            'best_recipes' => $best_recipes,
            'most_viewed_recipe' => $most_viewed_recipe,
        ));
    }
}
