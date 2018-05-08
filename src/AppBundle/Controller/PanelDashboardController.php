<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/panel")
 */
class PanelDashboardController extends Controller
{
    /**
     * @Route("/", name="panel_dashboard")
     */
    public function dashboardAction(Request $request)
    {

        return $this->render('panel/base.html.twig', array(

        ));
    }
}