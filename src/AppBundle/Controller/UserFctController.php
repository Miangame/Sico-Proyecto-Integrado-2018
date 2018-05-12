<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Distribution_company;
use AppBundle\Entity\User;
use AppBundle\Repository\CompanyRepository;
use AppBundle\Repository\Distribution_companyRepository;
use AppBundle\Repository\Request_companyRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserFctController extends Controller
{
    /**
     * @Route("/user/fct", name="user_fct")
     */
    public function dashboardAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->get("doctrine.orm.entity_manager");

        /** @var CompanyRepository $companyRepository */
        $companyRepository = $em->getRepository("AppBundle:Company");

        /** @var Request_companyRepository $request_companyRepository */
        $request_companyRepository = $em->getRepository("AppBundle:Request_company");

        /** @var Distribution_companyRepository $distribution_companyRepository */
        $distribution_companyRepository = $em->getRepository("AppBundle:Distribution_company");


        return $this->render('user/fct/view.html.twig', array(
            'companies' => $companyRepository->getCompanies(),
            'request_companies' => $request_companyRepository->getRequestCompanies(),
            'distribution_companies' => $distribution_companyRepository->getDistributionsCompanies()
        ));
    }
}