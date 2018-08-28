<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 23/08/2018
 * Time: 10:56
 */

namespace App\Controller;

use App\Entity\User;
use App\Event\UserResetPasswordEvent;
use App\Form\ChangePasswordType;
use App\Form\LostPasswordType;
use App\Form\ResetPasswordType;
use App\Handler\ChangePasswordHandler;
use App\Handler\LostPasswordHandler;
use App\Handler\ResetPasswordHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

    }

    /**
     * @param Request $reuest
     * @param EventDispatcherInterface $dispatcher
     *
     * @Route("/lost_password", methods={"GET","POST"}, name="security_lost_password")
     *
     */
    public function lostPasswordAction(
        Request $request,
        EventDispatcherInterface $dispatcher,
        LostPasswordHandler $lostPasswordHandler
    ){
        $userForm = new User();
        $form = $this->createForm(LostPasswordType::class, $userForm)->handleRequest($request);
        $user = $lostPasswordHandler->handle($form, $userForm);
        if ($user instanceof User) {
            $event = new UserResetPasswordEvent($user);
            $dispatcher->dispatch(UserResetPasswordEvent::NAME, $event);

            $this->addFlash('sucess', "un mail vous a été envoyé pour réinitialiser votre MDP");
            return $this->redirectToRoute('security_reset_password');
        }
        return $this->render('security/lost-password.html.twig', array(
            'form' => $form->createView()
        ));

    }



/**
 * @param Request $request
 * @param ResetPasswordHandler $resetPasswordHandler
 *
 * @Route("/reset-password", methods={"GET", "POST"}, name="security_reset_password")
 *
 *
 */
public
function resetPasswordAction(Request $request, ResetPasswordHandler $resetPasswordHandler)
{
    $user = new User();
    $form = $this->createForm(ResetPasswordType::class, $user)->handleRequest($request);

    if ($resetPasswordHandler->handle($form, $user)) {
        $this->addFlash('success', "Votre mot de passe a été changé, vous pouvez vous connecter.");
        return $this->redirectToRoute('login');
    }

    return $this->render('security/lost-password.html.twig', array(
        'form' => $form->createView()
    ));
}

/**
 * @param Request $request
 * @param ChangePasswordHandler $changePasswordHandler
 *
 * @Route("/change-password", methods={"GET", "POST"}, name="security_change_password")
 *
 */
public
function changePasswordAction(Request $request, ChangePasswordHandler $changePasswordHandler)
{
    $user = $this->getUser();
    $form = $this->createForm(ChangePasswordType::class, $user)->handleRequest($request);

    if ($changePasswordHandler->handle($form, $user)) {
        $this->addFlash('success', "Votre mot de passe a bien été changé.");
        return $this->redirectToRoute('trick_list');
    }

    return $this->render('security/change-password.html.twig', array(
        'form' => $form->createView()
    ));
}
}
