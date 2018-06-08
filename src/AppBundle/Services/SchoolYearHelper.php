<?php

namespace AppBundle\Services;


use AppBundle\Repository\SchoolYearRepository;
use Doctrine\ORM\EntityManager;

class SchoolYearHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getLastCourse()
    {
        /** @var SchoolYearRepository $schoolYearRepository */
        $schoolYearRepository = $this->em->getRepository("AppBundle:SchoolYear");

        return $schoolYearRepository->getLastCourse();
    }
}