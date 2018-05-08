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
        /** @var User $user */
        $user = $this->getUser();
        dump($user->getRol());
        die();
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}

