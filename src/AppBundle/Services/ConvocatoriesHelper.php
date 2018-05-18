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
}