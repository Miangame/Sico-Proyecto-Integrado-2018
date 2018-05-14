<?php

namespace AppBundle\Services;


use AppBundle\Entity\Student;
use AppBundle\Repository\CompanyRepository;
use AppBundle\Repository\StudentRepository;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\User;
use FOS\UserBundle\Model\UserManager;

class UsersHelper
{
    private $em;
    private $userManager;

    public function __construct(EntityManager $em, UserManager $userManager)
    {
        $this->em = $em;
        $this->userManager = $userManager;
    }

    public function getAllStudents()
    {
        $allUsers = $this->userManager->findUsers();
        $users = array();

        /** @var User $user */
        foreach ($allUsers as $user) {
            if ($user->hasRole('ROLE_TEACHER')) {
                $users[] = $user;
            }
        }

        return $users;
    }

    public function prepareOptions()
    {
        /** @var UserRepository $userRepository*/
        $userRepository = $this->em->getRepository("AppBundle:User");

        $users = Array();

        foreach ($userRepository->getUsers() as $user){
            $users[$user->__toString()] = $user;
        }
        return $users;
    }
}