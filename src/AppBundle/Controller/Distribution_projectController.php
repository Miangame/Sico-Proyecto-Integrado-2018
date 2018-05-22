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
     * @Route("/user/pi/distribution_project/new", name="user_pi_new_distribution_project")
     */
    public function newDistributionProjectAction(Request $request)
    {
        $distribution = new Distribution_project();
        $current_user = $this->getUser();

        $options = Array(
            "user" => $this->get('app.usersHelper')->prepareOptions(),
            "project" => $this->get('app.projectsHelper')->prepareOptions(),
            "student" => $this->get('app.studentsHelper')->prepareOptions($current_user->getCurrentConvocatory())
        );

        $form = $this->createForm(Distribution_ProjectType::class,$distribution,$options);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Asignación creada')
            ;

            return $this->redirectToRoute('user_pi', ['_fragment' => 'asign']);

        }



        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nueva asignación",
            'redirect' => 'user_pi'
        ));
    }

    /**
     * @Route("/user/pi/distribution_project/{id}/edit", name="user_pi_edit_distribution_project")
     */
    public function editProjectAction(Request $request, Distribution_project $distribution)
    {
        $current_user = $this->getUser();

        $options = Array(
            "user" => $this->get('app.usersHelper')->prepareOptions(),
            "user_selected" => $distribution->getUser(),
            "project" => $this->get('app.projectsHelper')->prepareOptions(),
            "project_selected" => $distribution->getProject(),
            "student" => $this->get('app.studentsHelper')->prepareOptions($current_user->getCurrentConvocatory()),
            "student_selected" => $distribution->getStudent(),
        );

        $form = $this->createForm(Distribution_ProjectType::class,$distribution,$options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($companyRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Asignación modificada')
            ;

            return $this->redirectToRoute( 'user_pi', ['_fragment' => 'asign']);

        }

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar asignación",
            'redirect' => 'user_pi'
        ));
    }

    /**
     * @Route("/user/pi/distribution_project/{id}/delete", name="user_pi_delete_distribution_project")
     */
    public function deleteProjectAction(Request $request,Distribution_project $distribution_project)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($distribution_project);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Asignación borrada')
        ;
        return $this->redirectToRoute('user_pi', ['_fragment' => 'asign']);
    }


}