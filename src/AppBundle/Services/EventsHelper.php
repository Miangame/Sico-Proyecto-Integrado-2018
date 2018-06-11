<?php


namespace AppBundle\Services;


use AppBundle\Repository\EventCalendarRepository;
use Doctrine\ORM\EntityManager;

class EventsHelper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEventsBySchoolYear($schoolYear)
    {
        /** @var EventCalendarRepository $eventsRepository */
        $eventsRepository = $this->em->getRepository('AppBundle:EventCalendar');

        return $eventsRepository->getEventsBySchoolYear($schoolYear);
    }

    public function getEventsBySchoolYearAndGroup($currentYear, $group)
    {
        /** @var EventCalendarRepository $eventsRepository */
        $eventsRepository = $this->em->getRepository('AppBundle:EventCalendar');

        return $eventsRepository->getEventsBySchoolYearAndGroup($currentYear, $group);
    }
}