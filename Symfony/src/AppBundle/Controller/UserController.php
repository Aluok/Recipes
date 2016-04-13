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
     * Lists an User ratings
     * @Route("/me/ratings", name="my_ratings")
     */
    public function ratingsAction()
    {
        return $this->render('User/ratings.html.twig', array(
            // ...
        ));
    }

    /**
     * List an user reviews
     * @Route("/me/reviews", name="my_reviews")
     */
    public function reviewsAction()
    {
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
        return $this->render('User/show_profile.html.twig', array(
            'user' => $user
        ));
    }
}
