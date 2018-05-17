<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\TeacherType;
use AppBundle\Services\UsersHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/panel/teacher")
 */
class PanelTeacherController extends Controller
{
    /**
     * @Route("/view", name="panel_teachers")
     */
    public function viewAction(Request $request)
    {
        /** @var UsersHelper $usersHelper */
        $usersHelper = $this->get('app.usersHelper');

        $teachers = $usersHelper->getAllTeachers();

        return $this->render('panel/teacher/view.html.twig', array(
            'teachers' => $teachers
        ));
    }

    /**
     * @Route("/new", name="new_teacher")
     */
    public function newTeacherAction(Request $request)
    {
        $teacher = new User();

        $teacher->setEnabled(true);
        $teacher->setRoles(array("ROLE_TEACHER"));
        $teacher->setToDistribute(true);

        $form = $this->createForm(TeacherType::class, $teacher);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teachertRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($teachertRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Profesor creado');
            return $this->redirectToRoute('panel_teachers');
        }

        return $this->render('panel/teacher/new.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo Profesor",
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_teacher")
     */
    public function editTeacherAction(Request $request, User $teacher)
    {
        $form = $this->createForm(TeacherType::class, $teacher);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($teacherRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Profesor modificado');
            return $this->redirectToRoute('panel_teachers');
        }

        return $this->render('panel/teacher/edit.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar profesor",
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete_teacher")
     */
    public function deleteTeacherAction(Request $request, User $teacher)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($teacher);
        $em->flush();
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Profesor borrado');
        return $this->redirectToRoute('panel_teachers');
    }

    /**
     * @Route("/{id}/enable_disable", name="enable_disable_teacher")
     */
    public function enableDisableTeacher(Request $request, User $teacher)
    {

        $teacher->setToDistribute(!$teacher->getToDistribute());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($teacher);
        $entityManager->flush();

        return $this->redirectToRoute('panel_teachers');
    }
}