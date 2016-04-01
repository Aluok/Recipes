<?php

namespace RecipeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RecipeBundle\Entity\Recipe;
use RecipeBundle\Entity\Step;
use RecipeBundle\Entity\Comment;
use RecipeBundle\Entity\Rating;
use RecipeBundle\Form\RecipeType;

/**
 * Recipe controller.
 *
 */
class RecipeController extends Controller
{
    /**
     * Lists all Recipe entities.
     *
     */
    public function listAction($sorter, $page, $filters)
    {
        $em = $this->getDoctrine()->getManager();
        if ($filters != "") {
            $filters = explode("/", $filters);

            $recipes = $em->getRepository('RecipeBundle:Recipe')->getListPublished($filters);
        } else {
            $recipes = $em->getRepository('RecipeBundle:Recipe')->findByIsPublished(1);
        }

        switch($sorter) {
            case 'views':
                $this->objSort($recipes, 'getViews', SORT_DESC);
                break;
            case 'ratings':
                $this->objSort($recipes, 'getRating', SORT_DESC);
                break;
            case 'alpha':
                $this->objSort($recipes, 'getTitle', SORT_ASC);
                break;
        }

        return $this->render('RecipeBundle:Recipes:list.html.twig', array(
            'recipes' => $recipes,
        ));
    }

    public function listReviewsAction($sorter, $page) {
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('RecipeBundle:Recipe')->findByIsPublished(0);
        switch($sorter) {
            case 'author':
                $this->objSort($recipes, 'getAuthor', SORT_ASC);
                break;
            case 'date':
                $this->objSort($recipes, 'getDate', SORT_DESC);
                break;
            case 'alpha':
                $this->objSort($recipes, 'getTitle', SORT_ASC);
                break;
        }
        return $this->render('RecipeBundle:Recipes:list.html.twig', array(
            'recipes' => $recipes,
            'sorters' => array('author', 'date', 'alpha'),
        ));
    }

    private function objSort(&$objArray,$indexFunction,$sort_flags=0) {
        if ($objArray == null || count($objArray) == 0)
            return;
        $indices = array();
        foreach($objArray as $obj) {
            $indeces[] = $obj->$indexFunction();
        }
        return array_multisort($indeces,$sort_flags, $objArray);
    }

    /**
     * Creates a new Recipe entity.
     *
     */
    public function addAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm('RecipeBundle\Form\RecipeType', $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe
                ->setAuthor($this->get('security.token_storage')->getToken()->getUser())
                ->setDate(new \DateTime())
                ->generateSlug();

            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);

            foreach($recipe->getSteps() as $step) {
                $step->setRecipe($recipe);
                $em->persist($step);
            }

            $em->flush();

            return $this->redirectToRoute('recipe_view', array('id' => $recipe->getId()));
        }

        return $this->render('RecipeBundle:Recipes:add_edit.html.twig', array(
            'recipe' => $recipe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Recipe entity.
     *
     */
    public function showAction(Recipe $recipe)
    {
        //TODO is there a real use?
        $deleteForm = $this->createDeleteForm($recipe);

        $recipe->setViews($recipe->getViews() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();

        return $this->render('RecipeBundle:Recipes:show.html.twig', array(
            'recipe' => $recipe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Recipe entity.
     */
    public function editAction(Request $request, Recipe $recipe)
    {
        $deleteForm = $this->createDeleteForm($recipe);
        $editForm = $this->createForm('RecipeBundle\Form\RecipeType', $recipe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);

            foreach($recipe->getSteps() as $step) {
                $step->setRecipe($recipe);
                $em->persist($step);
            }

            $em->flush();

            return $this->redirectToRoute('recipe_show', array('id' => $recipe->getId()));
        }

        return $this->render('RecipeBundle:Recipes:add_edit.html.twig', array(
            'recipe' => $recipe,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Recipe entity.
     */
    public function deleteAction(Request $request, Recipe $recipe)
    {
        $form = $this->createDeleteForm($recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recipe);
            $em->flush();
        }

        return $this->redirectToRoute('recipe_index');
    }

    /**
     * Comment a Recipe
     */
    public function commentAction(Request $request, Recipe $recipe) {
        $comment = new Comment();
        $form = $this->createForm('RecipeBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $comment
                ->setAuthor($this->get('security.token_storage')->getToken()->getUser())
                ->setDate(new \DateTime())
                ->setRecipe($recipe)
                ;
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('recipe_view', array('id' => $recipe->getId()));
        }
        return $this->render('RecipeBundle:Utils:generic_form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Comment ' . $recipe->getTitle(),
        ));
    }

    /**
     *
     */
    public function reviewAction(Request $request, Recipe $recipe)
    {
        $rating = new Rating();
        $form = $this->createForm('RecipeBundle\Form\RatingType', $rating);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $rating
                ->setAuthor($this->get('security.token_storage')->getToken()->getUser())
                ->setDate(new \DateTime())
                ->setRecipe($recipe)
                ;
            $em = $this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush();

            return $this->redirectToRoute('recipe_view', array('id' => $recipe->getId()));
        }
        return $this->render('RecipeBundle:Utils:generic_form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Review ' . $recipe->getTitle(),
        ));
    }

    /**
     * Creates a form to delete a Recipe entity.
     *
     * @param Recipe $recipe The Recipe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Recipe $recipe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recipe_delete', array('id' => $recipe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
