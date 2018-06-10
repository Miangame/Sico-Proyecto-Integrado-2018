<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course_cycle
 *
 * @ORM\Table(name="Course_cycle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Course_cycleRepository")
 */
class Course_cycle
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
     * @var string
     *
     * @ORM\Column(name="course", type="integer",
     *     columnDefinition="ENUM('1', '2')", nullable=false)
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="Cycle", inversedBy="courses_cycles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cycle;

    /**
     * @ORM\OneToMany(targetEntity="School_group", mappedBy="course_cycle")
     */
    private $school_groups;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="course_cycle")
     */
    private $modules;

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
     * Set cycle
     *
     * @param \AppBundle\Entity\Cycle $cycle
     *
     * @return Course_cycle
     */
    public function setCycle(\AppBundle\Entity\Cycle $cycle)
    {
        $this->cycle = $cycle;

        return $this;
    }

    /**
     * Get cycle
     *
     * @return \AppBundle\Entity\Cycle
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->school_groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add schoolGroup
     *
     * @param \AppBundle\Entity\School_group $schoolGroup
     *
     * @return Course_cycle
     */
    public function addSchoolGroup(\AppBundle\Entity\School_group $schoolGroup)
    {
        $this->school_groups[] = $schoolGroup;

        return $this;
    }

    /**
     * Remove schoolGroup
     *
     * @param \AppBundle\Entity\School_group $schoolGroup
     */
    public function removeSchoolGroup(\AppBundle\Entity\School_group $schoolGroup)
    {
        $this->school_groups->removeElement($schoolGroup);
    }

    /**
     * Get schoolGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSchoolGroups()
    {
        return $this->school_groups;
    }

    /**
     * Add module
     *
     * @param \AppBundle\Entity\Module $module
     *
     * @return Course_cycle
     */
    public function addModule(\AppBundle\Entity\Module $module)
    {
        $this->modules[] = $module;

        return $this;
    }

    /**
     * Remove module
     *
     * @param \AppBundle\Entity\Module $module
     */
    public function removeModule(\AppBundle\Entity\Module $module)
    {
        $this->modules->removeElement($module);
    }

    /**
     * Get modules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Set course
     *
     * @param integer $course
     *
     * @return Course_cycle
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return integer
     */
    public function getCourse()
    {
        return $this->course;
    }

    public function __toString()
    {
        return $this->getCourse() . $this->getCycle();
    }
}
