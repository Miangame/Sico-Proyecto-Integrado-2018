<?php


namespace AppBundle\Services;


use AppBundle\Entity\Course_cycle;
use AppBundle\Repository\Course_cycleRepository;
use AppBundle\Repository\CycleRepository;
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

    public function getSumHours($course)
    {
        /** @var Course_cycleRepository $courseCycleRepository */
        $courseCycleRepository = $this->em->getRepository('AppBundle:Course_cycle');

        /** @var CycleRepository $cycleRepository */
        $cycleRepository = $this->em->getRepository('AppBundle:Cycle');

        /** @var Course_cycle $courseCycle */
        $courseCycle = $courseCycleRepository->getCourseCycleById($course);

        $courseNumber = $courseCycle[0][0]["course"];
        $courseName = $courseCycle[0]["cycle"];

        if ($courseNumber == 1) {
            $result = $cycleRepository->getHours1ByCourseName($courseName);
        } else if ($courseNumber == 2) {
            $result = $cycleRepository->getHours2ByCourseName($courseName);
        }

        return $result;
    }

    public function getIdByGroup($idGroup)
    {
        /** @var Course_cycleRepository $courseCycleRepository */
        $courseCycleRepository = $this->em->getRepository('AppBundle:Course_cycle');

        return $courseCycleRepository->getIdByGroup($idGroup);
    }
}