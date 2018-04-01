<?php
namespace App\Controller;

use App\Form\Type\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Recipe;
use App\Entity\Step;
use App\Entity\Comment;
use App\Entity\Rating;
use App\Entity\Ingredient;
use App\Form\Type\RecipeType;

/**
 * Recipe controller.
 *
 */
class RecipeController extends Controller
{
    /**
     * Lists all Recipes.
     *
     * @Route("/recipe/list", name="recipe_list")
     */
    public function list(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Recipe::class)->getUniqueCategories();
        $ingredients = $em->getRepository(Ingredient::class)->getUniqueNames(true, $request->getLocale());
        return $this->render('Recipes/list.html.twig', array(
            'uri' => $this->generateUrl("recipe_api_list", array('action' => 'recipe')),
            'this_route' => 'recipe_list',
            'categories' => $categories,
            'ingredients' => $ingredients,
        ));
    }

    /**
     *
     * @Route("/reviews/list",name="recipe_list_for_reviews")
     */
    public function listReviews(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Recipe::class)->getUniqueCategories();
        $ingredients = $em->getRepository(Ingredient::class)->getUniqueNames(false, $request->getLocale());
        return $this->render('Recipes/list.html.twig', array(
            'uri' => $this->generateUrl("recipe_api_list", array('action' => 'review')),
            'this_route' => 'recipe_list_for_reviews',
            'categories' => $categories,
            'ingredients' => $ingredients,
        ));
    }

    /**
     * @Route("/recipe/new", name="recipe_new")
     * @Method({"GET"})
     */
    public function add(Request $request)
    {
        return $this->render('Recipes/add.html.twig', array(
        ));
    }


    /**
     * @Route("/recipe/new/scratch", name="recipe_new_scratch")
     * @Method({"GET","POST"})
     */
    public function addScratch(Request $request)
    {
        $recipe = new Recipe();
        if (count($recipe->getIngredients()) == 0) {
            $recipe->addIngredient(new Ingredient());
        }
        if (count($recipe->getSteps()) == 0) {
            $recipe->addStep(new Step());
        }
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $recipe
                    ->setAuthor($this->get('security.token_storage')->getToken()->getUser())
                    ->setDate(new \DateTime())
                    ->setLanguage($request->getLocale())
                    ->generateSlug();

                $em = $this->getDoctrine()->getManager();
                $em->persist($recipe);

                $em->flush();

                return $this->redirectToRoute('recipe_view', array('id' => $recipe->getId()));
            }
            //TODO include the logic if not valid
        }
        return $this->render('Forms/recipe_creation.html.twig', array(
            'recipe' => $recipe,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/recipe/new/import", name="recipe_new_import")
     * @Method({"GET","POST"})
     */
    public function addImport(Request $request)
    {
        $recipe = new Recipe();
        if (count($recipe->getIngredients()) == 0) {
            $recipe->addIngredient(new Ingredient());
        }
        if (count($recipe->getSteps()) == 0) {
            $recipe->addStep(new Step());
        }
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $recipe
                    ->setAuthor($this->get('security.token_storage')->getToken()->getUser())
                    ->setDate(new \DateTime())
                    ->generateSlug();

                $em = $this->getDoctrine()->getManager();
                $em->persist($recipe);

                $em->flush();

                return $this->redirectToRoute('recipe_view', array('id' => $recipe->getId()));
            }
            //TODO include the logic if not valid
        }
        return $this->render('Forms/recipe_import.html.twig', array(
            'recipe' => $recipe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Recipe.
     * @Route("/recipe/{id}", name="recipe_view")
     * @Method({"GET"})
     */
    public function showAction(Recipe $recipe)
    {
        $this->denyAccessUnlessGranted('view', $recipe);

        $recipe->setViews($recipe->getViews() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();

        $isAuthor = $this->get('security.token_storage')->getToken()->getUser() == $recipe->getAuthor();

        return $this->render('Recipes/show.html.twig', array(
            'recipe' => $recipe,
            'isEditable' => $isAuthor,
        ));
    }

    /**
     * Displays a form to edit an existing Recipe entity.
     * @Route("/recipe/{id}/edit", name="recipe_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, Recipe $recipe)
    {
        $this->denyAccessUnlessGranted('edit', $recipe);

        $deleteForm = $this->createDeleteForm($recipe);
        $editForm = $this->createForm(RecipeType::class, $recipe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);

            foreach ($recipe->getSteps() as $step) {
                $step->setRecipe($recipe);
                $em->persist($step);
            }

            $em->flush();

            return $this->redirectToRoute('recipe_view', array('id' => $recipe->getId()));
        }

        return $this->render('Recipes/edit.html.twig', array(
            'recipe' => $recipe,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Recipe:
     * @Route("/recipe/{id}", name="recipe_delete")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request, Recipe $recipe)
    {
        $this->denyAccessUnlessGranted('edit', $recipe);

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
     * @Route("/comment/{id}", name="recipe_comment")
     */
    public function commentAction(Request $request, Recipe $recipe)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        return $this->render('Utils/generic_form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Comment ' . $recipe->getTitle(),
        ));
    }

    /**
     * Review a Recipe
     * @Route("/review/{id}", name="recipe_review")
     */
    public function reviewAction(Request $request, Recipe $recipe)
    {
        $rating = new Rating();
        $form = $this->createForm(RatingType::class, $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        return $this->render('Utils/generic_form.html.twig', array(
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
