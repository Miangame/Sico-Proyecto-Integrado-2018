<?php


namespace AppBundle\Controller;

use AppBundle\Entity\EventCalendar;
use AppBundle\Entity\Module;
use AppBundle\Entity\School_group;
use AppBundle\Form\EventCalendarType;
use AppBundle\Services\CoursesHelper;
use AppBundle\Services\EventsHelper;
use AppBundle\Services\ModulesHelper;
use AppBundle\Services\SchoolGroupsHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/user/calendar")
 */
class UserCalendarController extends Controller
{
    /**
     * @Route("/view", name="user_calendar_view")
     */
    public function viewAction(Request $request)
    {
        /** @var SchoolGroupsHelper $groupsHelper */
        $groupsHelper = $this->get('app.schoolGroupsHelper');

        return $this->render('user/calendar/view.html.twig', array(
            'groups' => $groupsHelper->getGroups()
        ));
    }

    /**
     * @Route("/events", name="table_calendar_events")
     */
    public function eventsCalendarAction(Request $request)
    {
        /** @var EventsHelper $eventsHelper */
        $eventsHelper = $this->get('app.eventsHelper');

        $currentConvocatory = $this->getUser()->getCurrentConvocatory();
        $entityManager = $this->getDoctrine()->getManager();
        $emCov = $entityManager->getRepository('AppBundle:Convocatory');
        $currentYear = $emCov->find($currentConvocatory)->getSchoolYear();

        return $this->render('user/calendar/events.html.twig', array(
            'events' => $eventsHelper->getEventsBySchoolYear($currentYear)
        ));
    }

    /**
     * @Route("/events/new", name="new_event")
     */
    public function newCycleAction(Request $request)
    {
        $eventCalendar = new EventCalendar();

        $modules = array();
        $groups = array();

        /** @var ModulesHelper $modulesHelper */
        $modulesHelper = $this->get('app.modulesHelper');

        /** @var CoursesHelper $coursesHelper */
        $coursesHelper = $this->get('app.coursesHelper');

        /** @var SchoolGroupsHelper $groupsHelper */
        $groupsHelper = $this->get('app.schoolGroupsHelper');

        $currentConvocatory = $this->getUser()->getCurrentConvocatory();

        $currentSchoolYear = $coursesHelper->getCourseByConvocatory($currentConvocatory);

        /** @var Module $module */
        foreach ($modulesHelper->getModulesBySchoolYear($currentSchoolYear) as $module) {
            $modules[$module["initials"]] = $module["initials"];
        }

        /** @var School_group $group */
        foreach ($groupsHelper->getGroups() as $group) {
            $groups[$group->__toString()] = $group;
        }

        $options = array(
            "modules" => $modules,
            "groups" => $groups
        );

        $form = $this->createForm(EventCalendarType::class, $eventCalendar, $options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $emCov = $entityManager->getRepository('AppBundle:Convocatory');
            $currentYear = $emCov->find($currentConvocatory)->getSchoolYear();
            $eventRequest->setSchoolYear($currentYear);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Evento creado');
            return $this->redirectToRoute('table_calendar_events');
        }

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo evento",
            'redirect' => "table_calendar_events"
        ));
    }

    /**
     * @Route("/events/{id}/edit", name="edit_event")
     */
    public function editEventAction(Request $request, EventCalendar $eventCalendar)
    {
        $modules = array();
        $groups = array();

        /** @var ModulesHelper $modulesHelper */
        $modulesHelper = $this->get('app.modulesHelper');

        /** @var CoursesHelper $coursesHelper */
        $coursesHelper = $this->get('app.coursesHelper');

        /** @var SchoolGroupsHelper $groupsHelper */
        $groupsHelper = $this->get('app.schoolGroupsHelper');

        $currentConvocatory = $this->getUser()->getCurrentConvocatory();

        $currentSchoolYear = $coursesHelper->getCourseByConvocatory($currentConvocatory);

        /** @var Module $module */
        foreach ($modulesHelper->getModulesBySchoolYear($currentSchoolYear) as $module) {
            $modules[$module["initials"]] = $module["initials"];
        }

        /** @var School_group $group */
        foreach ($groupsHelper->getGroups() as $group) {
            $groups[$group->__toString()] = $group;
        }

        $options = array(
            "modules" => $modules,
            "groups" => $groups,
            "group_selected" => $eventCalendar->getGr(),
            "module_selected" => $eventCalendar->getModule(),
            "day_selected" => $eventCalendar->getWeekDay(),
            "initialHour" => $eventCalendar->getInitHour(),
            "finalHour" => $eventCalendar->getFinalHour(),
            "color_selected" => $eventCalendar->getColor(),
        );

        $form = $this->createForm(EventCalendarType::class, $eventCalendar, $options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $emCov = $entityManager->getRepository('AppBundle:Convocatory');
            $currentYear = $emCov->find($currentConvocatory)->getSchoolYear();
            $eventRequest->setSchoolYear($currentYear);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventRequest);
            $entityManager->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Evento creado');
            return $this->redirectToRoute('table_calendar_events');
        }

        return $this->render('user/forms/form.html.twig', array(
            'form' => $form->createView(),
            'title' => "Nuevo evento",
            'redirect' => "table_calendar_events"
        ));
    }

    /**
     * @Route("/events/{id}/delete", name="delete_event")
     */
    public function deleteEventAction(Request $request, EventCalendar $eventCalendar)
    {
        $type = "success";
        $msg = "Evento borrado";
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eventCalendar);
            $em->flush();
        } catch (DBALException $e) {
            $type = "error";
            switch ($e->getPrevious()->errorInfo[1]) {
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
        return $this->redirectToRoute('table_calendar_events');
    }

    /**
     * @Route("/get_events_data", name="get_events_data")
     */
    public function getEventsData(Request $request)
    {
        /** @var EventsHelper $eventsHelper */
        $eventsHelper = $this->get("app.eventsHelper");

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $arrayEvents = null;
        $contador = 0;

        $first_day = date('Y-m-d', strtotime('monday this week'));
        $second_day = date('Y-m-d', strtotime('tuesday this week'));
        $third_day = date('Y-m-d', strtotime('wednesday this week'));
        $forth_day = date('Y-m-d', strtotime('thursday this week'));
        $fifth_day = date('Y-m-d', strtotime('friday this week'));

        $currentConvocatory = $this->getUser()->getCurrentConvocatory();
        $entityManager = $this->getDoctrine()->getManager();
        $emCov = $entityManager->getRepository('AppBundle:Convocatory');
        $currentYear = $emCov->find($currentConvocatory)->getSchoolYear();

        $events = $eventsHelper->getEventsBySchoolYearAndGroup($currentYear, $_GET["group"]);

        foreach ($events as $event) {
            $arrayEvents[$contador]["module"] = $event["module"];
            $arrayEvents[$contador]["color"] = $event["color"];

            if ($event["weekDay"] == "monday") {
                $arrayEvents[$contador]["initHour"] = $first_day . "T" . $event["initHour"]->format("H:i");
                $arrayEvents[$contador]["finalHour"] = $first_day . "T" . $event["finalHour"]->format("H:i");
            } else if ($event["weekDay"] == "tuesday") {
                $arrayEvents[$contador]["initHour"] = $second_day . "T" . $event["initHour"]->format("H:i");
                $arrayEvents[$contador]["finalHour"] = $second_day . "T" . $event["finalHour"]->format("H:i");
            } else if ($event["weekDay"] == "wednesday") {
                $arrayEvents[$contador]["initHour"] = $third_day . "T" . $event["initHour"]->format("H:i");
                $arrayEvents[$contador]["finalHour"] = $third_day . "T" . $event["finalHour"]->format("H:i");
            } else if ($event["weekDay"] == "thursday") {
                $arrayEvents[$contador]["initHour"] = $forth_day . "T" . $event["initHour"]->format("H:i");
                $arrayEvents[$contador]["finalHour"] = $forth_day . "T" . $event["finalHour"]->format("H:i");
            } else if ($event["weekDay"] == "friday") {
                $arrayEvents[$contador]["initHour"] = $fifth_day . "T" . $event["initHour"]->format("H:i");
                $arrayEvents[$contador]["finalHour"] = $fifth_day . "T" . $event["finalHour"]->format("H:i");
            }

            $contador++;
        }

        $response = new JsonResponse();
        $response->setStatusCode(200);

        $response->setData(array(
            'response' => 'success',
            'events' => $serializer->serialize($arrayEvents, 'json')
        ));

        return $response;
    }
}