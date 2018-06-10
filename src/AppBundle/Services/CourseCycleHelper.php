<?php


namespace AppBundle\Services;


use AppBundle\Repository\Course_cycleRepository;
use Doctrine\ORM\EntityManager;

class CourseCycleHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getCoursesCycles()
    {
        /** @var Course_cycleRepository $courseCycleRepository */
        $courseCycleRepository = $this->em->getRepository('AppBundle:Course_cycle');

        return $courseCycleRepository->findAll();
    }
}