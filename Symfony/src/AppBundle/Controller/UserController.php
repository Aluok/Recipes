<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function recipesAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('AppBundle:Recipe')->findByAuthor($user);

        return $this->render('AppBundle:User:recipes.html.twig', array(
            'recipes' => $recipes,
        ));
    }

    public function ratingsAction()
    {
        return $this->render('AppBundle:User:ratings.html.twig', array(
            // ...
        ));
    }

    public function reviewsAction()
    {
        return $this->render('AppBundle:User:reviews.html.twig', array(
            // ...
        ));
    }

}
