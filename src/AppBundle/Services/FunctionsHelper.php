<?php

namespace AppBundle\Services;


use AppBundle\Repository\ConvocatoryRepository;
use AppBundle\Repository\SchoolYearRepository;
use Doctrine\ORM\EntityManager;

class FunctionsHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function isConvocatoryValid($convocatory)
    {
        /** @var SchoolYearRepository $schoolYearRepository */
        $schoolYearRepository = $this->em->getRepository("AppBundle:SchoolYear");

        /** @var ConvocatoryRepository $convocatoryRepository */
        $convocatoryRepository = $this->em->getRepository("AppBundle:Convocatory");
        $current_convocatory = $convocatoryRepository->find($convocatory);

        if($current_convocatory){
            return $current_convocatory->getSchoolYear()->getCourse() == $schoolYearRepository->getLastCourse()->getCourse();
        }
        return false; //Convocatoria no válida

    }
}