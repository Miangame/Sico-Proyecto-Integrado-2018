<?php

namespace AppBundle\Services;


use Doctrine\ORM\EntityManager;

class ConfigGeneralHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getConfig()
    {
        $configRepository = $this->em->getRepository("AppBundle:Configuration");
        return $configRepository->getConfig();
    }
}