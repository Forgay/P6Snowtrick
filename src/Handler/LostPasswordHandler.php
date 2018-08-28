<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 28/08/2018
 * Time: 10:21
 */

namespace App\Handler;

use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class LostPasswordHandler
 *
 */
class LostPasswordHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * LostPasswordHandler constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $entityManager;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param FormInterface $form
     * @param User $userForm
     *
     */
    public function handle(FormInterface $form, User $userForm)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->managerRegistry
                ->getRepository(User::class)
                ->findOneBy(['email' => $userForm->getEmail()]);

            if ($user) {
                $user->setResetToken(bin2hex(random_bytes(64)));
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return $user;
            }
        }

        return false;
    }
}