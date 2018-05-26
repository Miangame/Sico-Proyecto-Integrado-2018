<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Distribution_module_teacher;
use AppBundle\Entity\Module;
use AppBundle\Entity\School_group;
use AppBundle\Entity\User;
use AppBundle\Form\DistributionModuleTeacherType;
use AppBundle\Services\ConvocatoriesHelper;
use AppBundle\Services\CoursesHelper;
use AppBundle\Services\DistributionModuleTeacherHelper;
use AppBundle\Services\ModulesHelper;
use AppBundle\Services\SchoolGroupsHelper;
use AppBundle\Services\UsersHelper;
//use http\Env\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/panel/module_teacher")
 */
class PanelModuleTeacherController extends Controller
{
    /**
     * @Route("/view", name="panel_modules_teachers")
     */
    public function viewAction(Request $request)
    {

        /** @var DistributionModuleTeacherHelper $distributionModuleTeacherHelper */
        $distributionModuleTeacherHelper = $this->get('app.distributionModuleTeacherHelper');

        /** @var CoursesHelper $coursesHelper */
        $coursesHelper = $this->get('app.coursesHelper');

        $modulesTeachers = $distributionModuleTeacherHelper->getDistributionsLastYear();

        $courses = $coursesHelper->getCourses();

        return $this->render('panel/module_teacher/view.html.twig', array(
            'modulesTeachers' => $modulesTeachers,
            'courses' => $courses,
        ));
    }

    /**
     * @Route("/new", name="new_distribution_module_teacher")
     */
    public function newDistributionAction(Request $request)
    {
        $distribution = new Distribution_module_teacher();

        $modules = array();
        $teachers = array();
        $groups = array();
        $courses = array();

        /** @var ModulesHelper $modulesHelper */
        $modulesHelper = $this->get('app.modulesHelper');

        /** @var UsersHelper $teachersHelper */
        $teachersHelper = $this->get('app.usersHelper');

        /** @var SchoolGroupsHelper $groupsHelper */
        $groupsHelper = $this->get('app.schoolGroupsHelper');

        /** @var CoursesHelper $coursesHelper */
        $coursesHelper = $this->get('app.coursesHelper');

        /** @var Module $module */
        foreach ($modulesHelper->getAllModules() as $module) {
            $modules[$module->__toString()] = $module;
        }

        /** @var User $teacher */
        foreach ($teachersHelper->getAllTeachers() as $teacher) {
            $teachers[$teacher->__toString()] = $teacher;
        }

        /** @var School_group $group */
        foreach ($groupsHelper->getGroups() as $group) {
            $groups[$group->__toString()] = $group;
        }

        /** @var School_group $course */
        foreach ($coursesHelper->getCourses() as $course) {
            $courses[$course->__toString()] = $course;
        }

        $options = array(
            "modules" => $modules,
            "teachers" => $teachers,
            "groups" => $groups,
            "courses" => $courses
        );

        $form = $this->createForm(DistributionModuleTeacherType::class, $distribution, $options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($studentRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Asignación creada');
            return $this->redirectToRoute('panel_modules_teachers');
        }

        return $this->render('panel/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nueva asignación",
            'redirect' => "panel_modules_teachers",
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_distribution_module_teacher")
     */
    public function editDistributionAction(Request $request, Distribution_module_teacher $distribution)
    {
        $modules = array();
        $teachers = array();
        $groups = array();
        $courses = array();

        /** @var ModulesHelper $modulesHelper */
        $modulesHelper = $this->get('app.modulesHelper');

        /** @var UsersHelper $teachersHelper */
        $teachersHelper = $this->get('app.usersHelper');

        /** @var SchoolGroupsHelper $groupsHelper */
        $groupsHelper = $this->get('app.schoolGroupsHelper');

        /** @var CoursesHelper $coursesHelper */
        $coursesHelper = $this->get('app.coursesHelper');

        /** @var Module $module */
        foreach ($modulesHelper->getAllModules() as $module) {
            $modules[$module->__toString()] = $module;
        }

        /** @var User $teacher */
        foreach ($teachersHelper->getAllTeachers() as $teacher) {
            $teachers[$teacher->__toString()] = $teacher;
        }

        /** @var School_group $group */
        foreach ($groupsHelper->getGroups() as $group) {
            $groups[$group->__toString()] = $group;
        }

        /** @var School_group $course */
        foreach ($coursesHelper->getCourses() as $course) {
            $courses[$course->__toString()] = $course;
        }

        $options = array(
            "modules" => $modules,
            "module_selected" => $distribution->getModule(),
            "teachers" => $teachers,
            "teacher_selected" => $distribution->getTeacher(),
            "groups" => $groups,
            "group_selected" => $distribution->getGroup(),
            "courses" => $courses,
            "course_selected" => $distribution->getSchoolYear()
        );

        $form = $this->createForm(DistributionModuleTeacherType::class, $distribution, $options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentRequest = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($studentRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Asignación modificada');
            return $this->redirectToRoute('panel_modules_teachers');
        }

        return $this->render('panel/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modificar asignación",
            'redirect' => "panel_modules_teachers",
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete_distribution_module_teacher")
     */
    public function deleteDistributionAction(Request $request, Distribution_module_teacher $distribution)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($distribution);
        $em->flush();
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Distribución borrada');
        return $this->redirectToRoute('panel_modules_teachers');
    }

    /**
     * @Route("/getData", name="get_distribution_data")
     * @Method({"GET"})
     */
    public function getDistributionData(Request $request)
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        /** @var DistributionModuleTeacherHelper $distributionModuleTeacherHelper */
        $distributionModuleTeacherHelper = $this->get('app.distributionModuleTeacherHelper');
        $modulesTeachers = $distributionModuleTeacherHelper->getDistribution($_GET['course']);
        $response = new JsonResponse();
        $response->setStatusCode(200);

        $response->setData(array(
            'response' => 'success',
            'distributions' => $serializer->serialize($modulesTeachers, 'json')
        ));
        return $response;
    }
}