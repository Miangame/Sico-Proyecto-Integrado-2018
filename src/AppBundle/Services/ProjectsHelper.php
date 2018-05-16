<?php

namespace AppBundle\Services;


use Doctrine\ORM\EntityManager;

class ProjectsHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAllProject(){
        return $this->em->getRepository("AppBundle:Project")->getProjects();
    }
}