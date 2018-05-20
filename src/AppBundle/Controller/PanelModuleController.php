<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Module;
use AppBundle\Form\ModuleType;
use AppBundle\Services\ModulesHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/panel/module")
 */
class PanelModuleController extends Controller
{
    /**
     * @Route("/view", name="panel_modules")
     */
    public function viewAction(Request $request)
    {
        /** @var ModulesHelper $modulesHelper */
        $modulesHelper = $this->get('app.modulesHelper');
        $modules = $modulesHelper->getModules();

        return $this->render('panel/module/view.html.twig', array(
            'modules' => $modules
        ));
    }

    /**
     * @Route("/new", name="new_module")
     */
    public function newModuleAction(Request $request)
    {
        $module = new Module();

        $form = $this->createForm(ModuleType::class, $module);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moduleRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moduleRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Módulo creado');
            return $this->redirectToRoute('panel_modules');
        }

        return $this->render('panel/module/new.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo módulo",
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete_module")
     */
    public function deleteModuleAction(Request $request, Module $module)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($module);
        $em->flush();
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Módulo borrado');
        return $this->redirectToRoute('panel_modules');
    }
}