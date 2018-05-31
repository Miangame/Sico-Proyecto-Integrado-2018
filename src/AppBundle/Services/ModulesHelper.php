<?php

namespace AppBundle\Services;


use AppBundle\Repository\ModuleRepository;
use Doctrine\ORM\EntityManager;

class ModulesHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getModules()
    {
        /** @var ModuleRepository $moduleRepository */
        $moduleRepository = $this->em->getRepository('AppBundle:Module');

        return $moduleRepository->getModules();
    }

    public function getAllModules()
    {
        /** @var ModuleRepository $moduleRepository */
        $moduleRepository = $this->em->getRepository('AppBundle:Module');

        return $moduleRepository->getAllModules();
    }

    public function getActualHoursByGroup($group)
    {
        /** @var ModuleRepository $moduleRepository */
        $moduleRepository = $this->em->getRepository('AppBundle:Module');

        return $moduleRepository->getActualHoursByGroup($group);
    }
}