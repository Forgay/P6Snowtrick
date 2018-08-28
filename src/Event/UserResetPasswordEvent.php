<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 28/08/2018
 * Time: 10:29
 */

namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserResetPasswordEvent extends Event
{
    const NAME = 'user.lost-password';
    /** @var User
     *
     */
    private $user;

    /**
     * UserResetPasswordEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

}