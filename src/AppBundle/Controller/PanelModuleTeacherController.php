<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/panel/module_teacher")
 */
class PanelModuleTeacherController extends Controller
{
    /**
     * @Route("/view", name="panel_modules_teachers")
     */
    public function viewAction(Request $request)
    {

        return $this->render('panel/module_teacher/view.html.twig', array(

        ));
    }
}