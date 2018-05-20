<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Cycle;
use AppBundle\Entity\School_group;
use AppBundle\Form\GroupType;
use AppBundle\Services\CyclesHelper;
use AppBundle\Services\SchoolGroupsHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PanelGroupController extends Controller
{
    /**
     * @Route("/view", name="panel_groups")
     */
    public function viewAction(Request $request)
    {
        /** @var SchoolGroupsHelper $groupsHelper */
        $groupsHelper = $this->get('app.schoolGroupsHelper');
        $groups = $groupsHelper->getGroups();

        return $this->render('panel/group/view.html.twig', array(
            'groups' => $groups
        ));
    }

    /**
     * @Route("/new", name="new_group")
     */
    public function newGroupAction(Request $request)
    {
        $group = new School_group();
        $cycles = array();

        /** @var CyclesHelper $cyclesHelper */
        $cyclesHelper = $this->get('app.cyclesHelper');

        /** @var Cycle $cycle */
        foreach ($cyclesHelper->getCycles() as $cycle) {
            $cycles[$cycle->__toString()] = $cycle;
        }

        $options = array(
            "cycles" => $cycles
        );

        $form = $this->createForm(GroupType::class, $group, $options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Grupo creado');
            return $this->redirectToRoute('panel_groups');
        }

        return $this->render('panel/group/new.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo grupo",
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_group")
     */
    public function editGroupAction(Request $request, School_group $group)
    {
        $cycles = array();

        /** @var CyclesHelper $cyclesHelper */
        $cyclesHelper = $this->get('app.cyclesHelper');

        /** @var Cycle $cycle */
        foreach ($cyclesHelper->getCycles() as $cycle) {
            $cycles[$cycle->__toString()] = $cycle;
        }

        $options = array(
            "cycles" => $cycles,
            "cycle_selected" => $group->getCycle()
        );

        $form = $this->createForm(GroupType::class, $group, $options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Grupo modificado');
            return $this->redirectToRoute('panel_groups');
        }

        return $this->render('panel/group/edit.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar grupo",
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete_group")
     */
    public function deleteGroupAction(Request $request, School_group $group)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Grupo borrado');
        return $this->redirectToRoute('panel_groups');
    }
}