<?php
namespace UserBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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

  public function displayFormAction(Request $request){
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

// namespace UserBundle\Controller;
//
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
// use FOS\UserBundle\FOSUserEvents;
// use FOS\UserBundle\Event\GetResponseUserEvent;
// use Symfony\Component\HttpFoundation\Request;
// use FOS\UserBundle\Controller\RegistrationController as BaseController;
//
//
// class RegistrationController extends BaseController
// {
//   public function registerAction(Request $request)
//   {
//     /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
//     $formFactory = $this->get('fos_user.registration.form.factory');
//     /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
//     $userManager = $this->get('fos_user.user_manager');
//     /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
//     $dispatcher = $this->get('event_dispatcher');
//
//     $user = $userManager->createUser();
//     $user->setEnabled(true);
//
//     $event = new GetResponseUserEvent($user, $request);
//     $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);
//
//     if (null !== $event->getResponse()) {
//         return $event->getResponse();
//     }
//
//     $form = $formFactory->createForm();
//     $form->setData($user);
//
//     $form->handleRequest($request);
//
//     if ($form->isValid()) {
//         $event = new FormEvent($form, $request);
//         $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
//
//         $userManager->updateUser($user);
//
//         if (null === $response = $event->getResponse()) {
//             $url = $this->generateUrl('fos_user_registration_confirmed');
//             $response = new RedirectResponse($url);
//         }
//
//         $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
//
//         return $response;
//     }
//
//     return $this->render('RecipeBundle:Default:index.html.twig', array(
//         'form' => $form->createView(),
//         'modal_opened' => 'register',
//     ));
//   }
//
//   public function confirmedAction()
//   {
//     $this->addFlash('notice', 'Inscription confirmed. You are now connected');
//     return $this->redirectToRoute('recipe_home');
//   }
// }
// <?php
