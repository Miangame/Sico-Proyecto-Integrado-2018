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

        return $studentsRepository->getAllStudentsWithGroup();
    }

    public function getStudentsBySchoolYearConvocatory($schoolYear, $convocatory)
    {
        /** @var StudentRepository $studentsRepository */
        $studentsRepository = $this->em->getRepository("AppBundle:Student");

        return $studentsRepository->getStudentsBySchoolYearConvocatory($schoolYear, $convocatory);
    }

    public function getStudentsDistribution($convocatory){
        $studentsRepository = $this->em->getRepository("AppBundle:Student");
        $distributionCompany = $this->em->getRepository("AppBundle:Distribution_company");
        $distributionProject = $this->em->getRepository("AppBundle:Distribution_project");

        $students = $studentsRepository->getAllStudentsConvocatory($convocatory);
        foreach ($students as $student){
            $dsc = $distributionCompany->getAllForStudent($student->getId());
            $student->fct_tutor = (empty($dsc[0]) ? '~' : $dsc[0]->getUser()->__toString());
            $student->fct_company = (empty($dsc[0]) ? '~': $dsc[0]->getCompany()->__toString());
            $student->fct_id = (empty($dsc[0]) ? '~': $dsc[0]->getId());

            $dsp = $distributionProject->getAllForStudent($student->getId());
            $student->pi_tutor = (empty($dsp[0]) ? '~' : $dsp[0]->getUser()->__toString());
            $student->pi_project = (empty($dsp[0]) ? '~' : $dsp[0]->getProject()->__toString());
            $student->pi_id = (empty($dsp[0]) ? '~' : $dsp[0]->getId());
        }
        return $students;
    }

    public function prepareOptions($convocatory,$action,$type)
    {
        /** @var StudentRepository $studentsRepository */
        $studentsRepository = $this->em->getRepository("AppBundle:Student");
        $students = Array();
        $studentsResult = Array();

        switch ($action){
            case 'edit':
                $studentsResult = $studentsRepository->getAllStudentsConvocatory($convocatory);
                break;
            case 'new':
                $studentsResult = $studentsRepository->getAllStudentsNoDistribution($convocatory,$type);
                break;
            default:
                break;
        }

        foreach ($studentsResult as $student){
            $students[$student->__toString()] = $student;
        }
        return $students;
    }

}