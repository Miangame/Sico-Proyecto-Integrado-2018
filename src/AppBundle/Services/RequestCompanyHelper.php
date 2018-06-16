<?php

namespace AppBundle\Services;


use AppBundle\Entity\Company;
use AppBundle\Entity\Request_company;
use AppBundle\Repository\CompanyRepository;
use AppBundle\Repository\StudentRepository;
use Doctrine\ORM\EntityManager;

class RequestCompanyHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function getRequest($id)
    {
        /** @var Request_company $requestCompany*/
        $requestCompany = $this->em->getRepository("AppBundle:Request_company");
        return $requestCompany->find($id);
    }
}