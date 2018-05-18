<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\User;

class UserRepository extends EntityRepository
{
    public function getUsers()
    {
        $users = $this->findAll();
        $user_teacher = Array();
        /** @var User $user */
        foreach ($users as $user){
            if ($user->hasRole("ROLE_TEACHER"))
                $user_teacher[] = $user;
        }

        return $user_teacher;
    }

    public function getUsersValid(){
        $users = $this->findBy(Array("to_distribute"=>"1"));

        $user_teacher = Array();
        /** @var User $user */
        foreach ($users as $user){
            if ($user->hasRole("ROLE_TEACHER"))
                $user_teacher[] = $user;
        }

        return $user_teacher;
    }
}
