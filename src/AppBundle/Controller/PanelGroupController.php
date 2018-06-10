<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Course_cycle;
use AppBundle\Entity\Cycle;
use AppBundle\Entity\School_group;
use AppBundle\Form\GroupType;
use AppBundle\Services\CourseCycleHelper;
use AppBundle\Services\CyclesHelper;
use AppBundle\Services\SchoolGroupsHelper;
use Doctrine\DBAL\DBALException;
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
        $coursesCycles = array();

        /** @var CourseCycleHelper $coursesCyclesHelper */
        $coursesCyclesHelper = $this->get('app.courseCycleHelper');

        /** @var Course_cycle $courseCycle */
        foreach ($coursesCyclesHelper->getCoursesCycles() as $courseCycle) {
            $coursesCycles[$courseCycle->__toString()] = $courseCycle;
        }

        $options = array(
            "courses_cycles" => $coursesCycles
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

        return $this->render('panel/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo grupo",
            'redirect' => "panel_groups",
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_group")
     */
    public function editGroupAction(Request $request, School_group $group)
    {
        $coursesCycles = array();

        /** @var CourseCycleHelper $coursesCyclesHelper */
        $coursesCyclesHelper = $this->get('app.courseCycleHelper');

        /** @var Course_cycle $courseCycle */
        foreach ($coursesCyclesHelper->getCoursesCycles() as $courseCycle) {
            $coursesCycles[$courseCycle->__toString()] = $courseCycle;
        }

        $options = array(
            "courses_cycles" => $coursesCycles,
            "courses_cycles_selected" => $group->getCourseCycle(),
            "group_selected" => $group->getGr()
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

        return $this->render('panel/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar grupo",
            'redirect' => "panel_groups",
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete_group")
     */
    public function deleteGroupAction(Request $request, School_group $group)
    {
        $type = "success";
        $msg = "Grupo borrado";
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
        }catch (DBALException $e){
            $type = "error";
            switch ($e->getPrevious()->errorInfo[1]){
                case 1451:
                    $msg = "No se puede borrar si se está usando.";
                    break;
                default:
                    $msg = "No se ha podido borrar.";
                    break;
            }
        }
        $request->getSession()
            ->getFlashBag()
            ->add($type, $msg);
        return $this->redirectToRoute('panel_groups');
    }
}