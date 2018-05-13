<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Student;
use AppBundle\Form\StudentType;
use AppBundle\Services\StudentsHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/panel/student")
 */
class PanelStudentController extends Controller
{
    /**
     * @Route("/view", name="panel_students")
     */
    public function viewAction(Request $request)
    {
        /** @var StudentsHelper $studentsHelper */
        $studentsHelper = $this->get('app.studentsHelper');

        $students = $studentsHelper->getAllStudents();

        return $this->render('panel/student/view.html.twig', array(
            'students' => $students
        ));
    }

    /**
     * @Route("/new", name="new_student")
     */
    public function newStudentAction(Request $request)
    {
        $student = new Student();

        /** @var StudentsHelper $studentsHelper */
        $studentsHelper = $this->get('app.studentsHelper');

        $options = array(
            "groups" => array(
                "asdsad" => "asdasd",
                "zxczxc" => "zxczxc"
            ),
            "convocatories" => array(
                "asdsad" => "asdasd",
                "zxczxc" => "zxczxc"
            )
        );

        $form = $this->createForm(StudentType::class, $student, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($studentRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Alumno creado');
            return $this->redirectToRoute('panel_students');
        }

        return $this->render('panel/student/new.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo alumno",
        ));
    }
}