<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * SchoolYear
 *
 * @ORM\Table(name="School_year")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolYearRepository")
 * @UniqueEntity("course")
 */
class SchoolYear
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d{2}\/\d{2}$/")
     * @ORM\Column(name="course", type="string", length=255)
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="Request_company", mappedBy="schoolYear")
     */
    private $request_companies;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_module_teacher", mappedBy="schoolYear")
     */
    private $distributions_module_teacher;

    /**
     * @ORM\OneToMany(targetEntity="Convocatory", mappedBy="schoolYear")
     */
    private $convocatories;

    /**
     * @ORM\OneToMany(targetEntity="EventCalendar", mappedBy="schoolYear")
     */
    private $events;

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
     * Constructor
     */
    public function __construct()
    {
        $this->request_companies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set course
     *
     * @param string $course
     *
     * @return SchoolYear
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return string
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Add requestCompany
     *
     * @param \AppBundle\Entity\Request_company $requestCompany
     *
     * @return SchoolYear
     */
    public function addRequestCompany(\AppBundle\Entity\Request_company $requestCompany)
    {
        $this->request_companies[] = $requestCompany;

        return $this;
    }

    /**
     * Remove requestCompany
     *
     * @param \AppBundle\Entity\Request_company $requestCompany
     */
    public function removeRequestCompany(\AppBundle\Entity\Request_company $requestCompany)
    {
        $this->request_companies->removeElement($requestCompany);
    }

    /**
     * Get requestCompanies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequestCompanies()
    {
        return $this->request_companies;
    }


    /**
     * Add distributionsModuleTeacher
     *
     * @param \AppBundle\Entity\Distribution_module_teacher $distributionsModuleTeacher
     *
     * @return SchoolYear
     */
    public function addDistributionsModuleTeacher(\AppBundle\Entity\Distribution_module_teacher $distributionsModuleTeacher)
    {
        $this->distributions_module_teacher[] = $distributionsModuleTeacher;

        return $this;
    }

    /**
     * Remove distributionsModuleTeacher
     *
     * @param \AppBundle\Entity\Distribution_module_teacher $distributionsModuleTeacher
     */
    public function removeDistributionsModuleTeacher(\AppBundle\Entity\Distribution_module_teacher $distributionsModuleTeacher)
    {
        $this->distributions_module_teacher->removeElement($distributionsModuleTeacher);
    }

    /**
     * Get distributionsModuleTeacher
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDistributionsModuleTeacher()
    {
        return $this->distributions_module_teacher;
    }

    public function __toString()
    {
        return $this->course;
    }

    /**
     * Add convocatory
     *
     * @param \AppBundle\Entity\Convocatory $convocatory
     *
     * @return SchoolYear
     */
    public function addConvocatory(\AppBundle\Entity\Convocatory $convocatory)
    {
        $this->convocatories[] = $convocatory;

        return $this;
    }

    /**
     * Remove convocatory
     *
     * @param \AppBundle\Entity\Convocatory $convocatory
     */
    public function removeConvocatory(\AppBundle\Entity\Convocatory $convocatory)
    {
        $this->convocatories->removeElement($convocatory);
    }

    /**
     * Get convocatories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConvocatories()
    {
        return $this->convocatories;
    }

    /**
     * Add event
     *
     * @param \AppBundle\Entity\EventCalendar $event
     *
     * @return SchoolYear
     */
    public function addEvent(\AppBundle\Entity\EventCalendar $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\EventCalendar $event
     */
    public function removeEvent(\AppBundle\Entity\EventCalendar $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }
}
