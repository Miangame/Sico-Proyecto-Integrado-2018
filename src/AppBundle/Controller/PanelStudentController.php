<?php

namespace AppBundle\Controller;


use AppBundle\Entity\School_group;
use AppBundle\Entity\SchoolYear_convocatory;
use AppBundle\Entity\Student;
use AppBundle\Form\StudentType;
use AppBundle\Services\ConvocatoriesHelper;
use AppBundle\Services\SchoolGroupsHelper;
use AppBundle\Services\SchoolYearConvocatoriesHelper;
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

        /** @var ConvocatoriesHelper $convocatoriesHelper */
        $convocatoriesHelper = $this->get('app.convocatoriesHelper');

        $convocatories = $convocatoriesHelper->getAllConvocatories();

        $students = $studentsHelper->getAllStudents();

        return $this->render('panel/student/view.html.twig', array(
            'students' => $students,
            'convocatories' => $convocatories
        ));
    }

    /**
     * @Route("/new", name="new_student")
     */
    public function newStudentAction(Request $request)
    {
        $student = new Student();
        $groups = array();
        $schoolYear_convocatories = array();

        /** @var SchoolGroupsHelper $schoolGroupsHelper */
        $schoolGroupsHelper = $this->get('app.schoolGroupsHelper');

        /** @var SchoolYearConvocatoriesHelper $schoolYear_convocatoriesHelper */
        $schoolYear_convocatoriesHelper = $this->get('app.schoolYearConvocatoriesHelper');

        /** @var School_group $group */
        foreach ($schoolGroupsHelper->getGroups() as $group) {
            $groups[$group->__toString()] = $group;
        }

        /** @var SchoolYear_convocatory $schoolYearConvocatory */
        foreach ($schoolYear_convocatoriesHelper->getSchoolYearConvocatories() as $schoolYearConvocatory) {
            $schoolYear_convocatories[$schoolYearConvocatory->__toString()] = $schoolYearConvocatory;
        }

        $options = array(
            "groups" => $groups,
            "convocatories" => $schoolYear_convocatories
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

    /**
     * @Route("/{id}/edit", name="edit_student")
     */
    public function editStudentAction(Request $request, Student $student)
    {
        $groups = array();
        $schoolYear_convocatories = array();

        /** @var SchoolGroupsHelper $schoolGroupsHelper */
        $schoolGroupsHelper = $this->get('app.schoolGroupsHelper');

        /** @var SchoolYearConvocatoriesHelper $schoolYear_convocatoriesHelper */
        $schoolYear_convocatoriesHelper = $this->get('app.schoolYearConvocatoriesHelper');

        /** @var School_group $group */
        foreach ($schoolGroupsHelper->getGroups() as $group) {
            $groups[$group->__toString()] = $group;
        }

        /** @var SchoolYear_convocatory $schoolYearConvocatory */
        foreach ($schoolYear_convocatoriesHelper->getSchoolYearConvocatories() as $schoolYearConvocatory) {
            $schoolYear_convocatories[$schoolYearConvocatory->__toString()] = $schoolYearConvocatory;
        }

        $options = array(
            "groups" => $groups,
            "group_selected" => $student->getGroup(),
            "convocatories" => $schoolYear_convocatories,
            "schoolYear_convocatory_selected" => $student->getSchoolYearConvocatory()
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
                ->add('success', 'Alumno modificado');
            return $this->redirectToRoute('panel_students');
        }

        return $this->render('panel/student/edit.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar alumno",
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete_student")
     */
    public function deleteStudentAction(Request $request, Student $student)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Alumno borrado');
        return $this->redirectToRoute('panel_students');
    }
}