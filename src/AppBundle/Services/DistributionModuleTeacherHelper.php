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

    public function getDistributionsLastYear()
    {
        return $this->em->getRepository("AppBundle:Distribution_module_teacher")->getDistributionsLastYear();
    }

    public function getDistribution($course)
    {
        return $this->em->getRepository("AppBundle:Distribution_module_teacher")->getDistribution($course);
    }

    public function getHours()
    {
        return $this->em->getRepository("AppBundle:Distribution_module_teacher")->getHours();
    }
}