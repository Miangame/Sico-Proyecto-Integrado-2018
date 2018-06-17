<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserPIController extends Controller
{
    /**
     * @Route("/user/pi", name="user_pi")
     */
    public function dashboardAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine();

        $current_user = $this->getUser();

        return $this->render('user/pi/view.html.twig', array(
            'projects' => $this->get('app.projectsHelper')->getAllProject(),
            'projectsTutor' => $this->get('app.distributionprojectHelper')->
            getProjectsTutor($current_user, $current_user->getCurrentConvocatory()),
            'distributions' => $this->get('app.distributionprojectHelper')->
            getDistributionConvocatory($current_user->getCurrentConvocatory())
        ));
    }


}