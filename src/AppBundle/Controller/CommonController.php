<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class CommonController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     * @Security("has_role('ROLE_USER')")
     */
    public function dashboardAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user->hasRole("ROLE_ADMIN")) {
            return $this->redirect($this->generateUrl('panel_dashboard'));
        } else if ($user->hasRole("ROLE_TEACHER")) {
            return $this->redirect($this->generateUrl('index_web'));
        }

        die("Error");

    }
}