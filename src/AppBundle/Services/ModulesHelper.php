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

    public function getHoursByCourseCycle($courseCycle)
    {
        /** @var ModuleRepository $moduleRepository */
        $moduleRepository = $this->em->getRepository('AppBundle:Module');

        return $moduleRepository->getHoursByCourseCycle($courseCycle);
    }

    public function getModulesBySchoolYear($currentSchoolYear)
    {
        /** @var ModuleRepository $moduleRepository */
        $moduleRepository = $this->em->getRepository('AppBundle:Module');

        return $moduleRepository->getModulesBySchoolYear($currentSchoolYear);
    }

}