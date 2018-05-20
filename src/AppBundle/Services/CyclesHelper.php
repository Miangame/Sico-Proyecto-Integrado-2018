<?php


namespace AppBundle\Services;


use AppBundle\Repository\CycleRepository;
use Doctrine\ORM\EntityManager;

class CyclesHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getCycles()
    {
        /** @var CycleRepository $cycleRepository */
        $cycleRepository = $this->em->getRepository('AppBundle:Cycle');

        return $cycleRepository->getCycles();
    }
}