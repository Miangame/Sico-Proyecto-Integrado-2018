<?php

namespace AppBundle\Controller;


use AppBundle\Services\UsersHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PanelConfigController extends Controller
{
    /**
     * @Route("/panel/config", name="panel_config")
     */
    public function index(Request $request)
    {
        return $this->render('panel/config/view.html.twig', array());
    }
}