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

        $user = $this->getUser();
        return $this->render('panel/dashboard/view.html.twig', array(
            'user' => $user
        ));
    }
}