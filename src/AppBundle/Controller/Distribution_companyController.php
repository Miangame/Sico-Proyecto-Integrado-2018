<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
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
use AppBundle\Services\CompaniesHelper;

class Distribution_companyController extends Controller
{
    /**
     * @Route("/user/fct/distribution_company/new/{company}/{flag}/{student}", name="user_fct_new_distribution_company")
     */
    public function newDistributionCompanyAction(Request $request)
    {
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute('user_fct');
        }

        $company = "";
        $companyRequest = $request->get('company');
        if($companyRequest != '~'){
            $company = $this->get('app.companiesHelper')->getCompany($companyRequest);
        }

        $redirect = 'user_fct';

        $distribution = new Distribution_company();
        $current_user = $this->getUser();
        $student = $this->get('app.studentsHelper')->getStudent($request->get('student'));

        $options = Array(
            "user" => $this->get('app.usersHelper')->prepareOptions(),
            "company" => $this->get('app.companiesHelper')->prepareOptions(),
            "company_selected" => $company,
            "student" => $this->get('app.studentsHelper')
                ->prepareOptions($current_user->getCurrentConvocatory(), 'new', 'company'),
            "student_selected" => $student,
        );

        $form = $this->createForm(Distribution_CompanyType::class, $distribution, $options);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $distributionRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($distributionRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Asignación creada');

            if ($request->get('flag') == 'index') {
                $redirect = 'index_web';
            }

            return $this->redirectToRoute($redirect, ['_fragment' => 'asign']);

        }

        if ($request->get('flag') == 'index') {
            $redirect = 'index_web';
        }

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nueva asignación FCT",
            'redirect' => $redirect
        ));
    }

    /**
     * @Route("/user/fct/distribution_company/{id}/edit/{flag}", name="user_fct_edit_distribution_company")
     */
    public function editCompanyAction(Request $request, Distribution_company $distribution)
    {
        $redirect = 'user_fct';
        if ($request->get('flag') == 'index') {
            $redirect = 'index_web';
        }

        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute($redirect);
        }

        $current_user = $this->getUser();

        $options = Array(
            "user" => $this->get('app.usersHelper')->prepareOptions(),
            "user_selected" => $distribution->getUser(),
            "company" => $this->get('app.companiesHelper')->prepareOptions(),
            "company_selected" => $distribution->getCompany(),
            "student" => $this->get('app.studentsHelper')
                ->prepareOptions($current_user->getCurrentConvocatory(), 'edit', 'company'),
            "student_selected" => $distribution->getStudent(),
        );


        $form = $this->createForm(Distribution_CompanyType::class, $distribution, $options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($companyRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Asignación modificada');

            if ($request->get('flag') == 'index') {
                $redirect = 'index_web';
            }

            return $this->redirectToRoute($redirect, ['_fragment' => 'asign']);

        }

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar asignación FCT",
            'redirect' => $redirect
        ));
    }

    /**
     * @Route("/user/fct/distribution_company/{id}/delete", name="user_fct_delete_distribution_company")
     */
    public function deleteCompanyAction(Request $request, Distribution_company $distribution_company)
    {
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute('user_fct');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($distribution_company);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Asignación borrada');
        return $this->redirectToRoute('user_fct', ['_fragment' => 'asign']);
    }

}