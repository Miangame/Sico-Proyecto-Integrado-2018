<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Distribution_project;
use AppBundle\Entity\User;
use AppBundle\Form\Distribution_ProjectType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class Distribution_projectController extends Controller
{
    /**
     * @Route("/user/pi/distribution_project/new/{project}/{flag}/{student}", name="user_pi_new_distribution_project")
     */
    public function newDistributionProjectAction(Request $request)
    {
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute('user_pi');
        }

        $project = "";
        $projectRequest = $request->get('project');
        if($projectRequest != '~'){
            $project = $this->get('app.projectsHelper')->getProject($projectRequest);
        }

        $redirect = 'user_pi';
        $distribution = new Distribution_project();
        $current_user = $this->getUser();
        $student = $this->get('app.studentsHelper')->getStudent($request->get('student'));

        $options = Array(
            "user" => $this->get('app.usersHelper')->prepareOptions(),
            "project" => $this->get('app.projectsHelper')->prepareOptions(),
            "project_selected" => $project,
            "student" => $this->get('app.studentsHelper')
                ->prepareOptions($current_user->getCurrentConvocatory(), 'new', 'project'),
            "student_selected" => $student,
        );

        $form = $this->createForm(Distribution_ProjectType::class, $distribution, $options);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formRequest);
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
            'title' => "Nueva asignación PI",
            'redirect' => $redirect
        ));
    }

    /**
     * @Route("/user/pi/distribution_project/{id}/edit/{flag}", name="user_pi_edit_distribution_project")
     */
    public function editProjectAction(Request $request, Distribution_project $distribution)
    {
        $redirect = 'user_pi';

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
            "project" => $this->get('app.projectsHelper')->prepareOptions(),
            "project_selected" => $distribution->getProject(),
            "student" => $this->get('app.studentsHelper')
                ->prepareOptions($current_user->getCurrentConvocatory(), 'edit', 'project'),
            "student_selected" => $distribution->getStudent(),
        );

        $form = $this->createForm(Distribution_ProjectType::class, $distribution, $options);

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
            'title' => "Modificar asignación Pi",
            'redirect' => $redirect
        ));
    }

    /**
     * @Route("/user/pi/distribution_project/{id}/delete", name="user_pi_delete_distribution_project")
     */
    public function deleteProjectAction(Request $request, Distribution_project $distribution_project)
    {
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute('user_pi');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($distribution_project);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Asignación borrada');
        return $this->redirectToRoute('user_pi', ['_fragment' => 'asign']);
    }


}