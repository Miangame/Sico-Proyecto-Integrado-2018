<?php


namespace AppBundle\Services;


use AppBundle\Entity\School_group;
use AppBundle\Repository\CycleRepository;
use AppBundle\Repository\School_groupRepository;
use Doctrine\ORM\EntityManager;

class CyclesHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getCycles()
    {
        /** @var CycleRepository $cycleRepository */
        $cycleRepository = $this->em->getRepository('AppBundle:Cycle');

        return $cycleRepository->getCycles();
    }

    public function getTotalHours()
    {
        /** @var CycleRepository $cycleRepository */
        $cycleRepository = $this->em->getRepository('AppBundle:Cycle');

        return $cycleRepository->getTotalHours();
    }

    public function getSumTotalHours()
    {
        $result = "";

        $sumHours = 0;
        $sumHoursDesdoble = 0;

        $arrayResult = [];

        /** @var CycleRepository $cycleRepository */
        $cycleRepository = $this->em->getRepository('AppBundle:Cycle');

        /** @var School_groupRepository $groupRepository */
        $groupRepository = $this->em->getRepository('AppBundle:School_group');

        /** @var School_group $group */
        foreach ($groupRepository->getGroups() as $group) {
            $result = $cycleRepository->getSumHoursByCycle($group->getId());
            $course = $group->getCourseCycle()->getCourse();

            if ($course == 1) {
                $sumHours += $result[0]["titularHours1"];
                $sumHoursDesdoble += $result[0]["desdobleHours1"];
            } else if ($course == 2) {
                $sumHours += $result[0]["titularHours2"];
                $sumHoursDesdoble += $result[0]["desdobleHours2"];
            }
        }

        $arrayResult[0]["totalHours"] = $sumHours;
        $arrayResult[0]["totalHoursDesdoble"] = $sumHoursDesdoble;

        return $arrayResult;
    }
}