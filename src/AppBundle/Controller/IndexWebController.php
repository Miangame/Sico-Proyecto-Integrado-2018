<?php

namespace AppBundle\Controller;

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
    public function index(Request $request)
    {
        return $this->render('user/base.html.twig', array(
        ));
    }
}