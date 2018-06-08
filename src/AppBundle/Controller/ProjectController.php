<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use AppBundle\Form\ProjectType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    /**
     * @Route("/user/pi/project/new", name="user_pi_new_project")
     */
    public function newProjectAction(Request $request)
    {
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute('user_pi');
        }

        $project = new Project();

        $form = $this->createForm(ProjectType::class,$project);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($companyRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Proyecto creado')
            ;

            return $this->redirectToRoute('user_pi', ['_fragment' => 'proj']);

        }



        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo proyecto",
            'redirect' => 'user_pi'
        ));
    }

    /**
     * @Route("/user/pi/project/{id}/edit", name="user_pi_edit_project")
     */
    public function editProjectAction(Request $request,Project $project)
    {
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute('user_pi');
        }

        $form = $this->createForm(ProjectType::class,$project);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($companyRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Proyecto modificado')
            ;

            return $this->redirectToRoute('user_pi', ['_fragment' => 'proj']);

        }

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Editar proyecto",
            'redirect' => 'user_pi'
        ));
    }

    /**
     * @Route("/user/pi/project/{id}/delete", name="user_pi_delete_project")
     */
    public function deleteProjectAction(Request $request,Project $project)
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
        $em->remove($project);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Proyecto borrado')
        ;
        return $this->redirectToRoute('user_pi', ['_fragment' => 'proj']);
    }

    /**
     * @Route("/user/pi/project/{id}/show", name="user_pi_show_project", methods="GET")
     */
    public function showProject(Project $project)
    {
        $em = $this->getDoctrine();
        $current_convocatory = $this->getUser()->getCurrentConvocatory();

        return $this->render('user/pi/project/show.html.twig', array(
            'project' => $project,
            'distributions' => $this->get('app.distributionprojectHelper')->getDistributionByProject($project, $current_convocatory)
        ));
    }


}