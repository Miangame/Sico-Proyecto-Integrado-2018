<?php

namespace AppBundle\Controller;


use AppBundle\Entity\SchoolYear;
use AppBundle\Form\CourseType;
use AppBundle\Services\CoursesHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/panel/course")
 */
class PanelCourseController extends Controller
{
    /**
     * @Route("/view", name="panel_courses")
     */
    public function viewAction(Request $request)
    {
        /** @var CoursesHelper $groupsHelper */
        $groupsHelper = $this->get('app.coursesHelper');
        $courses = $groupsHelper->getCourses();

        return $this->render('panel/course/view.html.twig', array(
            'courses' => $courses
        ));
    }

    /**
     * @Route("/new", name="new_course")
     */
    public function newCourseAction(Request $request)
    {
        $course = new SchoolYear();

        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Curso creado');
            return $this->redirectToRoute('panel_courses');
        }

        return $this->render('panel/course/new.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo curso",
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_course")
     */
    public function editCourseAction(Request $request, SchoolYear $course)
    {
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Curso modificado');
            return $this->redirectToRoute('panel_courses');
        }

        return $this->render('panel/course/edit.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar curso",
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete_course")
     */
    public function deleteCourseAction(Request $request, SchoolYear $course)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($course);
        $em->flush();
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Curso borrado');
        return $this->redirectToRoute('panel_courses');
    }
}