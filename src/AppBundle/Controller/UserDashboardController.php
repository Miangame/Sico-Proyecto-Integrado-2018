<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserDashboardController extends Controller
{
    public function dashboardAction(Request $request)
    {
        $user = $this->getUser();
        return $this->render('commons/menuUser.html.twig', array(
            'user' => $user
        ));
    }
}

