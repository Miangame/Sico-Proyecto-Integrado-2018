<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Distribution_company;
use AppBundle\Entity\User;
use AppBundle\Form\CompanyType;
use AppBundle\Form\Distribution_CompanyType;
use AppBundle\Repository\CompanyRepository;
use AppBundle\Repository\Distribution_companyRepository;
use AppBundle\Repository\Request_companyRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class Distribution_companyController extends Controller
{
    /**
     * @Route("/user/fct/distribution_company/new", name="user_fct_new_distribution_company")
     */
    public function newDistributionCompanyAction(Request $request)
    {
        $distribution = new Distribution_company();

        $options = Array(
            "user" => Array("jponferrada"=>"1"),
            "company" => Array("NoSoloSoftware"=>"1"),
            "student" => Array("Federico"=>"1")
        );

        $form = $this->createForm(Distribution_CompanyType::class,$distribution,$options);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($companyRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Asignación creada')
            ;

            return $this->redirectToRoute('user_fct');

        }



        return $this->render('user/fct/distribution_company/new.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nueva asignación",
        ));
    }

}