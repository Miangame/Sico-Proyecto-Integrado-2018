<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 12/05/18
 * Time: 12:37
 */

namespace AppBundle\Services;


use AppBundle\Entity\Student;
use AppBundle\Repository\CompanyRepository;
use AppBundle\Repository\StudentRepository;
use Doctrine\ORM\EntityManager;

class StudentsHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAllStudents()
    {
        /** @var StudentRepository $studentsRepository */
        $studentsRepository = $this->em->getRepository("AppBundle:Student");

        return $studentsRepository->getAllStudents();
    }
}