<?php

namespace AppBundle\Services;


use AppBundle\Entity\Company;
use AppBundle\Repository\CompanyRepository;
use AppBundle\Repository\StudentRepository;
use Doctrine\ORM\EntityManager;

class CompaniesHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function prepareOptions()
    {
        /** @var CompanyRepository $companyRepository*/
        $companyRepository = $this->em->getRepository("AppBundle:Company");

        $companies = Array();

        foreach ($companyRepository->getCompanies() as $company){
            $companies[$company->getName()] = $company;
        }
        return $companies;
    }

    public function getCompany($id)
    {
        /** @var CompanyRepository $companyRepository*/
        $companyRepository = $this->em->getRepository("AppBundle:Company");
        return $companyRepository->find($id);
    }
}