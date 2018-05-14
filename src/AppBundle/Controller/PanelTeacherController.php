<?php

namespace AppBundle\Controller;


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
}