<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Cycle;
use AppBundle\Form\CycleType;
use AppBundle\Services\CyclesHelper;
use AppBundle\Services\ModulesHelper;
use Doctrine\DBAL\DBALException;
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

        $totalHours = $cyclesHelper->getTotalHours();

        return $this->render('panel/cycle/view.html.twig', array(
            'cycles' => $cycles,
            'totalHours' => $totalHours,
        ));
    }

    /**
     * @Route("/new", name="new_cycle")
     */
    public function newCycleAction(Request $request)
    {
        $cycle = new Cycle();

        $options = array(
            'hTitular1' => 0,
            'hTitular2' => 0,
            'hDesdoble1' => 0,
            'hDesdoble2' => 0
        );

        $form = $this->createForm(CycleType::class, $cycle, $options);

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

        $options = array(
            'hTitular1' => $cycle->getTitularHours1(),
            'hTitular2' => $cycle->getTitularHours2(),
            'hDesdoble1' => $cycle->getDesdobleHours1(),
            'hDesdoble2' => $cycle->getDesdobleHours2()
        );

        $form = $this->createForm(CycleType::class, $cycle, $options);

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
        $type = "success";
        $msg = "Ciclo borrado";
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cycle);
            $em->flush();
        }catch (DBALException $e){
            $type = "error";
            switch ($e->getPrevious()->errorInfo[1]){
                case 1451:
                    $msg = "No se puede borrar si está asignado.";
                    break;
                default:
                    $msg = "No se ha podido borrar.";
                    break;
            }
        }
        $request->getSession()
            ->getFlashBag()
            ->add($type, $msg);
        return $this->redirectToRoute('panel_cycles');
    }
}