<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;

class UserController extends Controller
{
    /**
     * List an user recipes
     * @Route("/me/recipes", name="my_recipes")
     */
    public function recipesAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('AppBundle:Recipe')->findByAuthor($user);
        return $this->render('User/recipes.html.twig', array(
            'recipes' => $recipes,
        ));
    }

    /**
     * List an user reviews
     * @Route("/me/reviews", name="my_reviews")
     */
    public function reviewsAction()
    {
        //TODO implements
        return $this->render('User/reviews.html.twig', array(
            // ...
        ));
    }

    /**
     * List an user reviews
     * @Route("/user/{id}", name="show_profile")
     */
    public function showProfile(User $user)
    {
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'self' => $user == $this->get('security.token_storage')->getToken()->getUser(),
        ));
    }
}
