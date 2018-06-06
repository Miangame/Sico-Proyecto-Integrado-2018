<?php

namespace AppBundle\Controller;


use AppBundle\Form\ConfigAdminType;
use AppBundle\Services\ConfigGeneralHelper;
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
        /** @var ConfigGeneralHelper $current_config */
        $current_config = $this->get('app.configHelper')->getConfig();

        $form_config_global = $this->formConfiguration(
            ConfigAdminType::class, $current_config, array(), $request);

        if ($form_config_global == "ok")
            return $this->redirectToRoute('panel_dashboard');

        return $this->render('panel/config/view.html.twig', array(
            'formConfig' => $form_config_global->createView()
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