<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\User;
use AppBundle\Repository\CompanyRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class IndexWebController extends Controller
{
    /**
     * @Route("/user", name="index_web")
     */
    public function indexAction(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $emCov = $entityManager->getRepository('AppBundle:Convocatory');
        $current_convocatory = $this->getUser()->getCurrentConvocatory();

        $currentYear = null;
        if($current_convocatory)
            $currentYear = $emCov->find($current_convocatory)->getSchoolYear();

        return $this->render('user/index.html.twig', array(
            'students' => $this->get('app.studentsHelper')->getStudentsDistribution($current_convocatory),
            'users' => $this->get('app.usersHelper')->getUserDistribution($current_convocatory, $currentYear),
            'convocatory' => $this->get('app.convocatoriesHelper')->getConvocatory($current_convocatory)
        ));
    }
}