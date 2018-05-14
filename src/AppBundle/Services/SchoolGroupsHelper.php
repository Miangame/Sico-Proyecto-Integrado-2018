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

        return $schoolGroupRepository->getGroups();
    }
}