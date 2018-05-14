<?php

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

    public function prepareOptions()
    {
        /** @var StudentRepository $studentsRepository */
        $studentsRepository = $this->em->getRepository("AppBundle:Student");

        $students = Array();

        foreach ($studentsRepository->getAllStudents() as $student){
            $students[$student->__toString()] = $student;
        }
        return $students;
    }
}