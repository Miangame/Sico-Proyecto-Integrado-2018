<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/panel/module")
 */
class PanelModuleController extends Controller
{
    /**
     * @Route("/view", name="panel_modules")
     */
    public function viewAction(Request $request)
    {

        return $this->render('panel/module/view.html.twig', array(

        ));
    }
}