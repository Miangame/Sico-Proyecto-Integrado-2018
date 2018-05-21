<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\User;
use AppBundle\Form\ConfigWebConvocatoryType;
use AppBundle\Form\ConfigWebType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ConfigWebController extends Controller
{
    /**
     * @Route("/user/config/{id}", name="user_config")
     */
    public function dashboardAction(Request $request, User $current_user)
    {
        if ($this->getUser()->getId() != $current_user->getId())
            return $this->redirectToRoute('index_web');

        $optionsConvocatory = Array(
            "convocatories" => $this->get('app.convocatoriesHelper')->prepareOptions(),
        );

        $form_convocatory = $this->formConfiguration(
            ConfigWebConvocatoryType::class, $current_user, $optionsConvocatory, $request);

        $form_config_global = $this->formConfiguration(
            ConfigWebType::class, new Configuration(), array(), $request);

        if ($form_convocatory == "ok")
            return $this->redirectToRoute('index_web');

        return $this->render('user/config/view.html.twig', array(
            'formConfigConvocatory' => $form_convocatory->createView(),
            'formConfigGlobal' => $form_config_global->createView(),
        ));
    }


    public function formConfiguration($classType, $class_instance, $options, $request)
    {

        $form = $this->createForm($classType, $class_instance, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formRequest);
            $entityManager->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Configuración aplicada');

            return "ok";

        }

        return $form;
    }
}