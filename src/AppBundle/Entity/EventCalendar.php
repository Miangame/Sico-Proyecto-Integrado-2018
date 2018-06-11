<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * EventCalendar
 *
 * @ORM\Table(name="event_calendar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventCalendarRepository")
 */
class EventCalendar
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="module", type="string", nullable=false)
     */
    private $module;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="weekDay", type="string", nullable=false)
     */
    private $weekDay;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="init_hour", type="time", nullable=false)
     */
    private $initHour;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="final_hour", type="time", nullable=false)
     */
    private $finalHour;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="color", type="string", nullable=false)
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolYear", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schoolYear;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="gr", type="string", nullable=false)
     */
    private $gr;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set module
     *
     * @param string $module
     *
     * @return EventCalendar
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set initHour
     *
     * @param \DateTime $initHour
     *
     * @return EventCalendar
     */
    public function setInitHour($initHour)
    {
        $this->initHour = $initHour;

        return $this;
    }

    /**
     * Get initHour
     *
     * @return \DateTime
     */
    public function getInitHour()
    {
        return $this->initHour;
    }

    /**
     * Set finalHour
     *
     * @param \DateTime $finalHour
     *
     * @return EventCalendar
     */
    public function setFinalHour($finalHour)
    {
        $this->finalHour = $finalHour;

        return $this;
    }

    /**
     * Get finalHour
     *
     * @return \DateTime
     */
    public function getFinalHour()
    {
        return $this->finalHour;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return EventCalendar
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set schoolYear
     *
     * @param \AppBundle\Entity\SchoolYear $schoolYear
     *
     * @return EventCalendar
     */
    public function setSchoolYear(\AppBundle\Entity\SchoolYear $schoolYear)
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }

    /**
     * Get schoolYear
     *
     * @return \AppBundle\Entity\SchoolYear
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }

    /**
     * Set weekDay
     *
     * @param string $weekDay
     *
     * @return EventCalendar
     */
    public function setWeekDay($weekDay)
    {
        $this->weekDay = $weekDay;

        return $this;
    }

    /**
     * Get weekDay
     *
     * @return string
     */
    public function getWeekDay()
    {
        return $this->weekDay;
    }

    /**
     * Set gr
     *
     * @param string $gr
     *
     * @return EventCalendar
     */
    public function setGr($gr)
    {
        $this->gr = $gr;

        return $this;
    }

    /**
     * Get gr
     *
     * @return string
     */
    public function getGr()
    {
        return $this->gr;
    }
}
