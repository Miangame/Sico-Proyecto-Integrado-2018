<?php

namespace AppBundle\Services;


use AppBundle\Repository\School_groupRepository;
use Doctrine\ORM\EntityManager;

class SchoolGroupsHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getGroups()
    {
        /** @var School_groupRepository $schoolGroupRepository */
        $schoolGroupRepository = $this->em->getRepository("AppBundle:School_group");

        $groups = $schoolGroupRepository->getGroups();
        usort($groups, function ($a, $b) {

            $aUsername = $a->__toString();
            $bUsername = $b->__toString();

            if (($aUsername == $bUsername)) {
                return 0;
            }

            return ($aUsername < $bUsername) ? -1 : 1;

        });

        return $groups;
    }

    public function getGroupsCourse($course)
    {
        /** @var School_groupRepository $schoolGroupRepository */
        $schoolGroupRepository = $this->em->getRepository("AppBundle:School_group");

        return $schoolGroupRepository->getGroupsCourse($course);
    }

    public function isGroupSecond($group)
    {
        return $group->getCourseCycle()->getCourse() == 2;
    }
}