<?php

namespace AppBundle\Controller;


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

        return $this->render('panel/course/view.html.twig', array(

        ));
    }
}