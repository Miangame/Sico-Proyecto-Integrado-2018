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
use Doctrine\DBAL\DBALException;
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

        if ($current_convocatory) {
            $current_schoolYear = $convocatoriesHelper->getIdCourseByConvocatory($current_convocatory);
            $students = $studentsHelper->getStudentsBySchoolYearConvocatory($current_schoolYear, $current_convocatory);
        }else{
            $students = Array();
        }



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
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute('panel_students');
        }

        $student = new Student();
        $groups = array();
        $convocatories = array();

        /** @var SchoolGroupsHelper $schoolGroupsHelper */
        $schoolGroupsHelper = $this->get('app.schoolGroupsHelper');

        /** @var ConvocatoriesHelper $convocatoriesHelper */
        $convocatoriesHelper = $this->get('app.convocatoriesHelper');


        /** @var School_group $group */
        foreach ($schoolGroupsHelper->getGroupsCourse(2) as $group) {
            $groups[$group->__toString()] = $group;
        }

        /** @var Convocatory $convocatory */
        foreach ($convocatoriesHelper->getAllConvocatories() as $convocatory) {
            if($current_convocatory == $convocatory->getId())
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
            if(!$schoolGroupsHelper->isGroupSecond($studentRequest->getGroup())) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', 'El alumno debe ser de 2º')
                ;
            }else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($studentRequest);
                $entityManager->flush();
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Alumno creado');
                return $this->redirectToRoute('panel_students');
            }
        }

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo alumno",
            'redirect' => "panel_students",
        ));
    }

    /**
     * @Route("/{id}/edit/{flag}", name="edit_student")
     */
    public function editStudentAction(Request $request, Student $student)
    {
        $redirect = 'panel_students';

        if ($request->get('flag') == 'index'){
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

        $groups = array();
        $convocatories = array();

        /** @var SchoolGroupsHelper $schoolGroupsHelper */
        $schoolGroupsHelper = $this->get('app.schoolGroupsHelper');

        /** @var ConvocatoriesHelper $convocatoriesHelper */
        $convocatoriesHelper = $this->get('app.convocatoriesHelper');


        /** @var School_group $group */
        foreach ($schoolGroupsHelper->getGroupsCourse(2) as $group) {
            $groups[$group->__toString()] = $group;
        }

        /** @var Convocatory $convocatory */
        foreach ($convocatoriesHelper->getAllConvocatories() as $convocatory) {
            if($current_convocatory == $convocatory->getId())
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

            if(!$schoolGroupsHelper->isGroupSecond($studentRequest->getGroup())) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', 'El alumno debe ser de 2º')
                ;
            }else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($studentRequest);
                $entityManager->flush();
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Alumno modificado');
                return $this->redirectToRoute('panel_students');
            }

        }

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar alumno",
            'redirect' => $redirect
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete_student")
     */
    public function deleteStudentAction(Request $request, Student $student)
    {
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        if(!$this->get('app.functionsHelper')->isConvocatoryValid($current_convocatory)) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'Convocatoria antigua (Solo lectura)')
            ;
            return $this->redirectToRoute('panel_students');
        }

        $type = "success";
        $msg = "Alumno borrado";
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($student);
            $em->flush();
        }catch (DBALException $e){
            $type = "error";
            switch ($e->getPrevious()->errorInfo[1]){
                case 1451:
                    $msg = "No se puede borrar si se está usando.";
                    break;
                default:
                    $msg = "No se ha podido borrar.";
                    break;
            }
        }
        $request->getSession()
            ->getFlashBag()
            ->add($type, $msg);

        return $this->redirectToRoute('panel_students');
    }
}