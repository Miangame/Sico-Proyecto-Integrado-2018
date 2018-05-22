<?php

namespace AppBundle\Services;


use AppBundle\Repository\ConvocatoryRepository;
use Doctrine\ORM\EntityManager;

class ConvocatoriesHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAllConvocatories()
    {
        /** @var ConvocatoryRepository $convocatoriesRepository */
        $convocatoriesRepository = $this->em->getRepository("AppBundle:Convocatory");

        return $convocatoriesRepository->getAllConvocatories();
    }

    public function prepareOptions($current_convocatory = null)
    {
        /** @var ConvocatoryRepository $convocatoriesRepository */
        $convocatoriesRepository = $this->em->getRepository("AppBundle:Convocatory");

        $convocatories = Array();

        foreach ($convocatoriesRepository->getConvocatories($current_convocatory) as $convocatory){
            $convocatories[$convocatory["convocatory"]] = $convocatory["id"];
        }
        return $convocatories;
    }

    public function getConvocatory($id){
        $convocatoriesRepository = $this->em->getRepository("AppBundle:Convocatory");
        $convocatory = $convocatoriesRepository->find(($id?$id:""));
        return empty($convocatory) ? "Sin convocatoria":$convocatory;
    }
}