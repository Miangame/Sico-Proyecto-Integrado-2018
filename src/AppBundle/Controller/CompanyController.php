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

class CompanyController extends Controller
{
    /**
     * @Route("/user/fct/company/new", name="user_fct_new_company")
     */
    public function newCompanyAction(Request $request)
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

            return $this->redirectToRoute('user_fct', ['_fragment' => 'emp']);

        }



        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nueva empresa",
            'redirect' => 'user_fct'
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

            return $this->redirectToRoute('user_fct', ['_fragment' => 'emp']);

        }

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Editar empresa",
            'redirect' => 'user_fct'
        ));
    }

    /**
     * @Route("/user/fct/company/{id}/delete", name="user_fct_delete_company")
     */
    public function deleteCompanyAction(Request $request,Company $company)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($company);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Empresa borrada')
        ;
        return $this->redirectToRoute('user_fct', ['_fragment' => 'emp']);
    }

    /**
     * @Route("/user/fct/company/{id}/show", name="user_fct_show_company", methods="GET")
     */
    public function showCompany(Company $company)
    {
        $em = $this->getDoctrine();

        return $this->render('user/fct/company/show.html.twig', array(
            'company' => $company,
            'distributions' => $em->getRepository(Distribution_company::class)->getDistributionBYCompany($company)
        ));
    }
}