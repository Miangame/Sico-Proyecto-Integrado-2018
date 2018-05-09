<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserDashboardController
 * @package AppBundle\Controller
 *
 * @Route("/user")
 */
class UserDashboardController extends Controller
{
    /**
     * @Route("/", name="user_dashboard")
     */
    public function dashboardAction(Request $request)
    {
        $user = $this->getUser();
        return $this->render('user/dashboard/view.html.twig', array(
            'user' => $user
        ));
    }
}

