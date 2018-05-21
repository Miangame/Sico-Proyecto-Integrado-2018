<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Cycle;
use AppBundle\Form\CycleType;
use AppBundle\Services\CyclesHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/panel/cycle")
 */
class PanelCycleController extends Controller
{
    /**
     * @Route("/view", name="panel_cycles")
     */
    public function viewAction(Request $request)
    {

        /** @var CyclesHelper $cyclesHelper */
        $cyclesHelper = $this->get('app.cyclesHelper');

        $cycles = $cyclesHelper->getCycles();

        return $this->render('panel/cycle/view.html.twig', array(
            'cycles' => $cycles
        ));
    }

    /**
     * @Route("/new", name="new_cycle")
     */
    public function newCycleAction(Request $request)
    {
        $cycle = new Cycle();

        $form = $this->createForm(CycleType::class, $cycle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cycleRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cycleRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Ciclo creado');
            return $this->redirectToRoute('panel_cycles');
        }

        return $this->render('panel/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo ciclo",
            'redirect' => "panel_cycles"
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_cycle")
     */
    public function editCycleAction(Request $request, Cycle $cycle)
    {
        $form = $this->createForm(CycleType::class, $cycle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cycleRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cycleRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Ciclo modificado');
            return $this->redirectToRoute('panel_cycles');
        }

        return $this->render('panel/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar ciclo",
            'redirect' => "panel_cycles"
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete_cycle")
     */
    public function deleteCycleAction(Request $request, Cycle $cycle)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($cycle);
        $em->flush();
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Ciclo borrado');
        return $this->redirectToRoute('panel_cycles');
    }
}