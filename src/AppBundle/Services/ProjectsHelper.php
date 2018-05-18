<?php

namespace AppBundle\Services;


use AppBundle\Repository\ProjectRepository;
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

    public function prepareOptions()
    {
        /** @var ProjectRepository $projectRepository*/
        $projectRepository = $this->em->getRepository("AppBundle:Project");

        $projects = Array();

        foreach ($projectRepository->getProjects() as $project){
            $projects[$project->getName()] = $project;
        }
        return $projects;
    }
}