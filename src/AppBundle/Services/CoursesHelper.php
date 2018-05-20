<?php


namespace AppBundle\Services;

use AppBundle\Repository\SchoolYearRepository;
use Doctrine\ORM\EntityManager;

class CoursesHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getCourses()
    {
        /** @var SchoolYearRepository $cycleRepository */
        $coursesRepository = $this->em->getRepository('AppBundle:SchoolYear');

        return $coursesRepository->getCourses();
    }
}