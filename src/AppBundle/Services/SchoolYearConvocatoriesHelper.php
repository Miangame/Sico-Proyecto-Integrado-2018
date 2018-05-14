<?php

namespace AppBundle\Services;


use AppBundle\Repository\ConvocatoryRepository;
use AppBundle\Repository\SchoolYear_convocatoryRepository;
use Doctrine\ORM\EntityManager;

class SchoolYearConvocatoriesHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getSchoolYearConvocatories()
    {
        /** @var SchoolYear_convocatoryRepository $schoolYearConvocatoryRepository */
        $schoolYearConvocatoryRepository = $this->em->getRepository("AppBundle:SchoolYear_convocatory");

        return $schoolYearConvocatoryRepository->getSchoolYearConvocatories();
    }
}