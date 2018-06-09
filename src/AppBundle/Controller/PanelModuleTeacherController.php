<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Distribution_module_teacher;
use AppBundle\Entity\Module;
use AppBundle\Entity\School_group;
use AppBundle\Entity\User;
use AppBundle\Form\DistributionModuleTeacherType;
use AppBundle\Services\ConvocatoriesHelper;
use AppBundle\Services\CoursesHelper;
use AppBundle\Services\CyclesHelper;
use AppBundle\Services\DistributionModuleTeacherHelper;
use AppBundle\Services\ModulesHelper;
use AppBundle\Services\SchoolGroupsHelper;
use AppBundle\Services\UsersHelper;
//use http\Env\Response;
use Doctrine\DBAL\DBALException;
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
        /** @var CyclesHelper $cyclesHelper */
        $cyclesHelper = $this->get('app.cyclesHelper');

        /** @var DistributionModuleTeacherHelper $distributionModuleTeacherHelper */
        $distributionModuleTeacherHelper = $this->get('app.distributionModuleTeacherHelper');

        /** @var CoursesHelper $coursesHelper */
        $coursesHelper = $this->get('app.coursesHelper');

        /** @var SchoolGroupsHelper $groupsHelper */
        $groupsHelper = $this->get('app.schoolGroupsHelper');

        $modulesTeachers = $distributionModuleTeacherHelper->getDistributionsLastYear();

        $courses = $coursesHelper->getCourses();

        $totalHours = $cyclesHelper->getSumTotalHours();

        $actualHours = $distributionModuleTeacherHelper->getHours();

        $groups = $groupsHelper->getGroups();

        return $this->render('panel/module_teacher/view.html.twig', array(
            'modulesTeachers' => $modulesTeachers,
            'courses' => $courses,
            'groups' => $groups,
            'totalHours' => $totalHours,
            'actualHours' => $actualHours,
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
        $courses = array();

        /** @var ModulesHelper $modulesHelper */
        $modulesHelper = $this->get('app.modulesHelper');

        /** @var UsersHelper $teachersHelper */
        $teachersHelper = $this->get('app.usersHelper');

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

        /** @var School_group $course */
        foreach ($coursesHelper->getCourses() as $course) {
            $courses[$course->__toString()] = $course;
        }

        $options = array(
            "modules" => $modules,
            "teachers" => $teachers,
            "courses" => $courses
        );

        $form = $this->createForm(DistributionModuleTeacherType::class, $distribution, $options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $distModTeacher = $form->getData();

            if ($distModTeacher->getDesdoble()) {
                $distModTeacher->setHours($distModTeacher->getModule()->getHoursDesdoble());
            } else {
                $distModTeacher->setHours($distModTeacher->getModule()->getHours());
            }

            $distModTeacher->setGroup($distModTeacher->getModule()->getGroup());

            $type = 'success';
            $msg = 'Asignación creada';
            try{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($distModTeacher);
                $entityManager->flush();
            }catch (DBALException $e){//Error al asignar
                $type = 'error';
                switch ($e->getPrevious()->getCode()){
                    case 23000:
                        $msg = 'Asignación ya existente';
                        break;
                    default:
                        $msg = 'Error inesperado en la asignación';
                        break;
                }
            }
            $request->getSession()
                ->getFlashBag()
                ->add($type, $msg);

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
        $courses = array();

        /** @var ModulesHelper $modulesHelper */
        $modulesHelper = $this->get('app.modulesHelper');

        /** @var UsersHelper $teachersHelper */
        $teachersHelper = $this->get('app.usersHelper');

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

        /** @var School_group $course */
        foreach ($coursesHelper->getCourses() as $course) {
            $courses[$course->__toString()] = $course;
        }

        $options = array(
            "modules" => $modules,
            "module_selected" => $distribution->getModule(),
            "teachers" => $teachers,
            "teacher_selected" => $distribution->getTeacher(),
            "courses" => $courses,
            "course_selected" => $distribution->getSchoolYear()
        );

        $form = $this->createForm(DistributionModuleTeacherType::class, $distribution, $options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $distModTeacherRequest = $form->getData();
            if ($distModTeacherRequest->getDesdoble()) {
                $distModTeacherRequest->setHours($distModTeacherRequest->getModule()->getHoursDesdoble());
            } else {
                $distModTeacherRequest->setHours($distModTeacherRequest->getModule()->getHours());
            }

            $distModTeacherRequest->setGroup($distModTeacherRequest->getModule()->getGroup());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($distModTeacherRequest);
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