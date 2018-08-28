<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 28/08/2018
 * Time: 10:49
 */

namespace App\Subscriber;


use App\Event\UserResetPasswordEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;
use Swift_Mailer;
use Swift_Message;

class SecuritySubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * SecuritySubscriber constructor.
     * @param Environment $twig
     * @param Swift_Mailer $mailer
     */
    public function __construct(Environment $twig, Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }


    public static function getSubscribedEvents()
    {
       return [UserResetPasswordEvent::NAME => 'onUserResetPassword'];
    }

    /**
     * @param UserResetPasswordEvent $event
     */
    public function onUserResetPassword(UserResetPasswordEvent $event)
    {
        $message = (new Swift_Message('Réinitialisation du mot de passe'))
            ->setFrom('noreply@snowtricks.com')
            ->setTo($event->getUser()->getEmail())
            ->setBody(
                $this->twig->render('email/lost-password.html.twig', ['user' => $event->getUser()]),
                'text/html'
            );

        $this->mailer->send($message);
    }
}