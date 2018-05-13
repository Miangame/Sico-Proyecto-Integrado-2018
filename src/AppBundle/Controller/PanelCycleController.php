<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/panel/cycle")
 */
class PanelCycleController extends Controller
{
    /**
     * @Route("/view", name="panel_cycles")
     */
    public function viewAction(Request $request)
    {

        return $this->render('panel/cycle/view.html.twig', array(

        ));
    }
}