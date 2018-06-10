<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Course_cycle;
use AppBundle\Entity\Cycle;
use AppBundle\Entity\Module;
use AppBundle\Form\ModuleType;
use AppBundle\Repository\Course_cycleRepository;
use AppBundle\Services\CourseCycleHelper;
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

        /** @var CourseCycleHelper $coursesHelper */
        $coursesHelper = $this->get('app.courseCycleHelper');

        $courses = $coursesHelper->getCoursesCycles();
        $modules = $modulesHelper->getModules();

        return $this->render('panel/module/view.html.twig', array(
            'modules' => $modules,
            'courses' => $courses,
        ));
    }

    /**
     * @Route("/new", name="new_module")
     */
    public function newModuleAction(Request $request)
    {
        $module = new Module();

        $coursesCycles = array();

        /** @var CourseCycleHelper $courseCycleHelper */
        $courseCycleHelper = $this->get('app.courseCycleHelper');

        /** @var Course_cycle $courseCycle */
        foreach ($courseCycleHelper->getCoursesCycles() as $courseCycle) {
            $coursesCycles[$courseCycle->__toString()] = $courseCycle;
        }

        $options = array(
            "course_cycle" => $coursesCycles
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
        $coursesCycles = array();

        /** @var CourseCycleHelper $courseCycleHelper */
        $courseCycleHelper = $this->get('app.courseCycleHelper');

        /** @var Course_cycle $courseCycle */
        foreach ($courseCycleHelper->getCoursesCycles() as $courseCycle) {
            $coursesCycles[$courseCycle->__toString()] = $courseCycle;
        }

        $options = array(
            "course_cycle" => $coursesCycles,
            "course_cycle_selected" => $module->getCourseCycle()
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