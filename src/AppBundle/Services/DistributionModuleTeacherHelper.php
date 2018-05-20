<?php


namespace AppBundle\Services;


use Doctrine\ORM\EntityManager;

class DistributionModuleTeacherHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getDistributions()
    {
        return $this->em->getRepository("AppBundle:Distribution_module_teacher")->getDistributions();
    }
}