<?php

namespace AppBundle\Controller;


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
        return $this->render('panel/base.html.twig', array(
        ));
    }
}