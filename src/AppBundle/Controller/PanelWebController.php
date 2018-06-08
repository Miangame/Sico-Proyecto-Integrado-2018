<?php

namespace AppBundle\Controller;


use AppBundle\Services\UsersHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PanelWebController extends Controller
{
    /**
     * @Route("/panel", name="panel_dashboard")
     */
    public function index(Request $request)
    {
        /** @var UsersHelper $usersHelper */
        $usersHelper = $this->get('app.usersHelper');

        $teachers = $usersHelper->getAllTeachers();

        return $this->render('panel/teacher/view.html.twig', array(
            'teachers' => $teachers
        ));
    }
}