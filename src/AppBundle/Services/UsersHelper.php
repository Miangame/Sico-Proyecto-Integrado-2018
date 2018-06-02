<?php

namespace AppBundle\Services;


use AppBundle\Entity\Student;
use AppBundle\Repository\CompanyRepository;
use AppBundle\Repository\ConvocatoryRepository;
use AppBundle\Repository\Distribution_module_teacherRepository;
use AppBundle\Repository\StudentRepository;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\User;
use FOS\UserBundle\Model\UserManager;
use AppBundle\Model\TeacherData;

class UsersHelper
{
    private $em;
    private $userManager;

    public function __construct(EntityManager $em, UserManager $userManager)
    {
        $this->em = $em;
        $this->userManager = $userManager;
    }

    public function getAllTeachers()
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

    public function getUserDistribution($convocatory)
    {

        /** @var UserRepository $teacherRepository */
        $teacherRepository = $this->em->getRepository("AppBundle:User");

        /** @var ConvocatoryRepository $convocatoryRepository */
        $convocatoryRepository = $this->em->getRepository("AppBundle:Convocatory");

        /** @var Distribution_module_teacherRepository $distributionRepository */
        $distributionRepository = $this->em->getRepository("AppBundle:Distribution_Module_Teacher");

        $teachers = Array();
        $teacherResult = $teacherRepository->getUsersValid();

        if ($convocatoryRepository->findBy(array('id' => $convocatory)) != null) {
            /** @var User $teacher */
            foreach ($teacherResult as $teacher) {
                array_push(
                    $teachers, new TeacherData(
                        $teacher,
                        $teacherRepository->getPIDistribution($convocatory, $teacher->getId()),
                        $teacherRepository->getFCTDistribution($convocatory, $teacher->getId()),
                        $this->calcRecuction(
                            $distributionRepository->getHoursByUserId(
                                $teacher->getId()
                            )
                        )
                    )
                );
            }
        }
        return $teachers;
    }

    private function calcRecuction($hours)
    {
        return ($hours % 2 == 0) ? $hours / 2 : round($hours / 2);
    }

    public function prepareOptions()
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository("AppBundle:User");

        $users = Array();

        foreach ($userRepository->getUsersValid() as $user) {
            $users[$user->__toString()] = $user;
        }
        return $users;
    }
}