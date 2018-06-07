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
        $current_convocatory = $this->getUser()->getCurrentConvocatory();
        $this->createConfigData();
        return $this->render('user/index.html.twig', array(
            'students' => $this->get('app.studentsHelper')->getStudentsDistribution($current_convocatory),
            'users' => $this->get('app.usersHelper')->getUserDistribution($current_convocatory),
            'convocatory' => $this->get('app.convocatoriesHelper')->getConvocatory($current_convocatory)
        ));
    }

    private function createConfigData()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $config = $em->getRepository(Configuration::class)->findAll();

        if (!$config) {
            $newConfig = new Configuration();

            $newConfig->setId(1);
            $newConfig->setWeightFct(1);
            $newConfig->setWeightPi(1);

            $em->persist($newConfig);
            $em->flush();
        }
    }
}