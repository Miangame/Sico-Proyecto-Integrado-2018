<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Repository\CompanyRepository;
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

        return $this->render('user/fct/view.html.twig', array(
            'companies' => $companyRepository->getCompanies(),
        ));
    }
}