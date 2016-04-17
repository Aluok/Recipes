<?php
namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        $response = parent::registerAction($request);
        return $response;
    // if ($response instanceof RedirectResponse) {
    //   return $this->redirect('RecipeBundle:Default:index.html.twig');
    // }
    //  return $this->render('RecipeBundle:Default:index.html.twig',
    //     array('form' => $form->createView(),
    //     'modal_opened' => 'register'));

    }

    public function confirmedAction()
    {
        $this->addFlash('notice', 'Inscription confirmed. You are now connected');
        return $this->redirectToRoute('recipe_home');
    }

    public function displayFormAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);
        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
