<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Distribution_company;
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

    /**
     * @Route("/user/fct/company/new", name="user_fct_new_company")
     */
    public function newCopanyAction(Request $request)
    {
        $company = new Company();

        $form = $this->createForm(CompanyType::class,$company);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($companyRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Empresa creada')
            ;

            return $this->redirectToRoute('user_fct');

        }



        return $this->render('user/fct/company/new.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nueva empresa",
        ));
    }

    /**
     * @Route("/user/fct/company/{id}/edit", name="user_fct_edit_company")
     */
    public function editCopanyAction(Request $request,Company $company)
    {
        $form = $this->createForm(CompanyType::class,$company);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($companyRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Empresa modificada')
            ;

            return $this->redirectToRoute('user_fct');

        }



        return $this->render('user/fct/company/edit.html.twig', array(
            'form' => $form->createView(),
            'title' => "Editar empresa",
        ));
    }

    /**
     * @Route("/user/fct/company/{id}/delete", name="user_fct_delete_company")
     */
    public function deleteCopanyAction(Request $request,Company $company)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($company);
        $em->flush();
        return $this->redirectToRoute('user_fct');
    }
}