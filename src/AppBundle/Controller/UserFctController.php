<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Distribution_company;
use AppBundle\Entity\Request_company;
use AppBundle\Entity\User;
use AppBundle\Form\CompanyType;
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
        $em = $this->getDoctrine();

        return $this->render('user/fct/view.html.twig', array(
            'companies' => $em->getRepository(Company::class)->getCompanies(),
            'request_companies' => $em->getRepository(Request_company::class)->getRequestCompanies(),
            'distribution_companies' => $em->getRepository(Distribution_company::class)->getDistributionsCompanies()
        ));
    }
}