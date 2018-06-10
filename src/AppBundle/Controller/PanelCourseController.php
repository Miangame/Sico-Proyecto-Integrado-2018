<?php

namespace AppBundle\Controller;


use AppBundle\Entity\SchoolYear;
use AppBundle\Form\CourseType;
use AppBundle\Services\CoursesHelper;
use Doctrine\DBAL\DBALException;
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

        return $this->render('panel/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo curso",
            'redirect' => 'panel_courses'
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

        return $this->render('panel/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar curso",
            'redirect' => 'panel_courses'
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete_course")
     */
    public function deleteCourseAction(Request $request, SchoolYear $course)
    {
        $type = "success";
        $msg = "Curso borrado";
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($course);
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

        return $this->redirectToRoute('panel_courses');
    }
}