<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Cycle;
use AppBundle\Entity\Module;
use AppBundle\Form\ModuleType;
use AppBundle\Services\CyclesHelper;
use AppBundle\Services\ModulesHelper;
use AppBundle\Services\SchoolGroupsHelper;
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

        $cycles = array();
        $groups = array();

        /** @var CyclesHelper $cyclesHelper */
        $cyclesHelper = $this->get('app.cyclesHelper');

        /** @var SchoolGroupsHelper $groupsHelper */
        $groupsHelper = $this->get('app.schoolGroupsHelper');


        /** @var Cycle $group */
        foreach ($cyclesHelper->getCycles() as $cycle) {
            $cycles[$cycle->__toString()] = $cycle;
        }

        /** @var Cycle $group */
        foreach ($groupsHelper->getGroups() as $group) {
            $groups[$group->__toString()] = $group;
        }

        $options = array(
            "cycles" => $cycles,
            "groups" => $groups
        );

        $form = $this->createForm(ModuleType::class, $module, $options);

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

        return $this->render('panel/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo módulo",
            'redirect' => "panel_modules",
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_module")
     */
    public function editModuleAction(Request $request, Module $module)
    {
        $cycles = array();
        $groups = array();

        /** @var CyclesHelper $cyclesHelper */
        $cyclesHelper = $this->get('app.cyclesHelper');

        /** @var SchoolGroupsHelper $groupsHelper */
        $groupsHelper = $this->get('app.schoolGroupsHelper');


        /** @var Cycle $group */
        foreach ($cyclesHelper->getCycles() as $cycle) {
            $cycles[$cycle->__toString()] = $cycle;
        }

        /** @var Cycle $group */
        foreach ($groupsHelper->getGroups() as $group) {
            $groups[$group->__toString()] = $group;
        }

        $options = array(
            "cycles" => $cycles,
            "groups" => $groups,
            "cycle_selected" => $module->getCycle(),
            "group_selected" => $module->getGroup(),
        );

        $form = $this->createForm(ModuleType::class, $module, $options);

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

        return $this->render('panel/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo módulo",
            'redirect' => "panel_modules",
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