<?php

namespace RecipeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RecipeBundle\Entity\Recipe;
use RecipeBundle\Entity\Step;
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
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('RecipeBundle:Recipe')->findAll();

        return $this->render('RecipeBundle:Recipes:index.html.twig', array(
            'recipes' => $recipes,
        ));
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
        if (! $recipe->getIsPublished()) {
          $this->addFlash('error', 'This recipe doesn\'t exists');
          return $this->redirectToRoute('recipe_list');
        }
        $deleteForm = $this->createDeleteForm($recipe);

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

            return $this->redirectToRoute('recipe_edit', array('id' => $recipe->getId()));
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
