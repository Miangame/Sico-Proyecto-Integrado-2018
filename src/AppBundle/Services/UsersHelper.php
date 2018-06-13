<?php

namespace AppBundle\Services;


use AppBundle\Entity\Configuration;
use AppBundle\Entity\Student;
use AppBundle\Repository\CompanyRepository;
use AppBundle\Repository\ConfigurationRepository;
use AppBundle\Repository\ConvocatoryRepository;
use AppBundle\Repository\CycleRepository;
use AppBundle\Repository\Distribution_module_teacherRepository;
use AppBundle\Repository\StudentRepository;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
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

    /**
     * Mostrar Profesores con los datos del reparto
     * @param $convocatory
     * @return array
     */
    public function getUserDistribution($convocatory, $currentYear)
    {

        /** @var UserRepository $teacherRepository */
        $teacherRepository = $this->em->getRepository("AppBundle:User");

        /** @var ConvocatoryRepository $convocatoryRepository */
        $convocatoryRepository = $this->em->getRepository("AppBundle:Convocatory");

        /** @var CycleRepository $cycleRepository */
        $cycleRepository = $this->em->getRepository("AppBundle:Cycle");

        /** @var Distribution_module_teacherRepository $distributionRepository */
        $distributionRepository = $this->em->getRepository("AppBundle:Distribution_Module_Teacher");

        $teachers = Array();
        $teacherResult = $teacherRepository->getUsersValid();

        if ($convocatoryRepository->findBy(array('id' => $convocatory)) != null) {
            $sumTotalPond = $this->sumTotalPond($teacherResult, $convocatory, $teacherRepository);

            /** @var User $teacher */
            foreach ($teacherResult as $teacher) {
                $numFCT = $teacherRepository->getFCTDistribution($convocatory, $teacher->getId());
                $numPI = $teacherRepository->getPIDistribution($convocatory, $teacher->getId());
                $sumTeacher = $numFCT + $numPI;
                $reduct = $this->calcReduction(
                    $distributionRepository->getHours2ByUserId(
                        $teacher->getId(),
                        $currentYear
                    )
                );
                $porc2 = $this->calcPorc2(
                    $distributionRepository->getHours2ByUserId($teacher->getId(), $currentYear),
                    $distributionRepository->getHours2()
                );
                $porcCycle = $this->calcPorcCycle(
                    $distributionRepository->getHoursByUserId($teacher->getId(), $currentYear),
                    $cycleRepository->getHours()
                );
                $porcReduct = $this->calcPorcReduct(
                    $reduct,
                    $this->sumTotalReduct($teacherResult, $distributionRepository, $currentYear)
                );
                $ideal2 = ($sumTotalPond * $porc2) / 100;
                $idealCycle = ($sumTotalPond * $porcCycle) / 100;
                $idealReduct = ($sumTotalPond * $porcReduct) / 100;

                $restaIdeal2 = round($ideal2 - $sumTeacher, 2);
                $restaIdealCycle = round($idealCycle - $sumTeacher, 2);
                $restaIdealReduct = round($idealReduct - $sumTeacher, 2);

                array_push(
                    $teachers, new TeacherData(
                        $teacher,
                        $numPI,
                        $numFCT,
                        $reduct,
                        $restaIdeal2,
                        $restaIdealCycle,
                        $restaIdealReduct
                    )
                );
            }
        }
        return $teachers;
    }

    /**
     * Calcular el porcentaje de reducción
     * @param $reduct
     * @param $totalReduct
     * @return float|int
     */
    private function calcPorcReduct($reduct, $totalReduct)
    {
        if ($totalReduct == 0) {
            return 0;
        }

        return (($reduct * 100) / $totalReduct);
    }

    /**
     * Sumar todas las horas de reducción de todos los usuarios
     * @param $teachers
     * @param $distributionRepository
     * @return float|int
     */
    private function sumTotalReduct($teachers, $distributionRepository, $schoolYear)
    {
        $sum = 0;
        foreach ($teachers as $teacher) {
            $sum += $this->calcReduction($distributionRepository->getHoursByUserId(
                $teacher->getId(),
                $schoolYear
            ));
        }

        return $sum;
    }

    /**
     * Calcular cuanto porcetaje equivale el total de horas de un profesor en torno al total de horas de todos los
     * profesores
     *
     * @param $totalHoursTeacher
     * @param $totalHours
     * @return float|int
     */
    private function calcPorcCycle($totalHoursTeacher, $totalHours)
    {
        if ($totalHours == 0) {
            return 0;
        }

        return (($totalHoursTeacher * 100) / $totalHours);
    }

    /**
     * Calcular la ponderación de un profesor tomando en cuenta el número de FCT's y PI's
     *
     * @param $numFCT
     * @param $numPI
     * @return float|int
     */
    private function calcSumPonderation($numFCT, $numPI)
    {
        /** @var ConfigurationRepository $config */
        $config = $this->em->getRepository('AppBundle:Configuration')->find(1);
        $pesoFCT = $config->getWeightFCT();
        $pesoPI = $config->getWeightPi();
        return ($numFCT * $pesoFCT) + ($numPI * $pesoPI);
    }

    /**
     * Calcular el porcentaje de horas de segundo de un profesor tomando en cuenta el total de
     * horas de segundo
     *
     * @param $total2HoursUser
     * @param $total2Hours
     * @return float|int
     */
    private function calcPorc2($total2HoursUser, $total2Hours)
    {
        if ($total2Hours == 0) {
            return 0;
        }
        return (($total2HoursUser * 100) / $total2Hours);
    }

    /**
     * Sumar el total de ponderaciones de todos los profesores
     * @param $teachers
     * @param $convocatory
     * @param $teacherRepository
     * @return float|int
     */
    private function sumTotalPond($teachers, $convocatory, $teacherRepository)
    {
        $sum = 0;
        foreach ($teachers as $teacher) {
            $numFCT = $teacherRepository->getFCTDistribution($convocatory, $teacher->getId());
            $numPI = $teacherRepository->getPIDistribution($convocatory, $teacher->getId());
            $sum += $this->calcSumPonderation($numFCT, $numPI);
        }

        return $sum;
    }

    /**
     * Calcular la reducción de un profesor tomando en cuenta las horas del mismo
     *
     * @param $hours
     * @return float|int
     */
    private function calcReduction($hours)
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

    public function getUserById($userId)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository("AppBundle:User");

        return $userRepository->getUserById($userId);
    }
}