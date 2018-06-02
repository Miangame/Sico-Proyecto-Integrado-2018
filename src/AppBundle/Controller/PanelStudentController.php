<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Convocatory;
use AppBundle\Entity\School_group;
use AppBundle\Entity\Student;
use AppBundle\Form\StudentType;
use AppBundle\Services\ConvocatoriesHelper;
use AppBundle\Services\CoursesHelper;
use AppBundle\Services\CyclesHelper;
use AppBundle\Services\SchoolGroupsHelper;
use AppBundle\Services\StudentsHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/user/student")
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

        /** @var CoursesHelper $coursesHelper */
        $coursesHelper = $this->get('app.coursesHelper');

        /** @var CyclesHelper $cyclesHelper */
        $cyclesHelper = $this->get('app.cyclesHelper');

        $courses = $coursesHelper->getCourses();

        $convocatories = $convocatoriesHelper->getAllConvocatories();

        $current_convocatory = $this->getUser()->getCurrentConvocatory();

        if ($current_convocatory == null) {
            return $this->render('user/errors/errorNoConvocatory.html.twig');
        }

        $current_schoolYear = $convocatoriesHelper->getIdCourseByConvocatory($current_convocatory);
        $students = $studentsHelper->getStudentsBySchoolYearConvocatory($current_schoolYear, $current_convocatory);

        return $this->render('user/student/view.html.twig', array(
            'students' => $students,
            'convocatories' => $convocatories,
            'courses' => $courses,
            'cycles' => $cyclesHelper->getCycles()
        ));
    }

    /**
     * @Route("/new", name="new_student")
     */
    public function newStudentAction(Request $request)
    {
        $student = new Student();
        $groups = array();
        $convocatories = array();

        /** @var SchoolGroupsHelper $schoolGroupsHelper */
        $schoolGroupsHelper = $this->get('app.schoolGroupsHelper');

        /** @var ConvocatoriesHelper $convocatoriesHelper */
        $convocatoriesHelper = $this->get('app.convocatoriesHelper');


        /** @var School_group $group */
        foreach ($schoolGroupsHelper->getGroups() as $group) {
            $groups[$group->__toString()] = $group;
        }

        /** @var Convocatory $convocatory */
        foreach ($convocatoriesHelper->getAllConvocatories() as $convocatory) {
            $convocatories[$convocatory->__toString()] = $convocatory;
        }

        $options = array(
            "groups" => $groups,
            "convocatories" => $convocatories
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

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo alumno",
            'redirect' => "panel_students",
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_student")
     */
    public function editStudentAction(Request $request, Student $student)
    {
        $groups = array();
        $convocatories = array();

        /** @var SchoolGroupsHelper $schoolGroupsHelper */
        $schoolGroupsHelper = $this->get('app.schoolGroupsHelper');

        /** @var ConvocatoriesHelper $convocatoriesHelper */
        $convocatoriesHelper = $this->get('app.convocatoriesHelper');


        /** @var School_group $group */
        foreach ($schoolGroupsHelper->getGroups() as $group) {
            $groups[$group->__toString()] = $group;
        }

        /** @var Convocatory $convocatory */
        foreach ($convocatoriesHelper->getAllConvocatories() as $convocatory) {
            $convocatories[$convocatory->__toString()] = $convocatory;
        }

        $options = array(
            "groups" => $groups,
            "group_selected" => $student->getGroup(),
            "convocatories" => $convocatories,
            "convocatory_selected" => $student->getConvocatory()
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

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar alumno",
            'redirect' => "panel_students"
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