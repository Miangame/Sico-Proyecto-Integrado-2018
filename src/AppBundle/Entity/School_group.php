<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * School_group
 *
 * @ORM\Table(name="School_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\School_groupRepository")
 */
class School_group
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;


    /**
     * @ORM\Column(name="initials", type="string", unique=true, nullable=false)
     */
    private $initials;


    /**
     * @ORM\ManyToOne(targetEntity="Cycle", inversedBy="school_groups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cycle;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="group")
     */
    private $students_groups;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_module_teacher", mappedBy="group")
     */
    private $distributions_module_teacher;

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
     * Set name
     *
     * @param string $name
     *
     * @return School_group
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set initials
     *
     * @param string $initials
     *
     * @return School_group
     */
    public function setInitials($initials)
    {
        $this->initials = $initials;

        return $this;
    }

    /**
     * Get initials
     *
     * @return string
     */
    public function getInitials()
    {
        return $this->initials;
    }

    /**
     * Set cycle
     *
     * @param \AppBundle\Entity\Cycle $cycle
     *
     * @return School_group
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
        $this->distributions_module_teacher = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add distributionsModuleTeacher
     *
     * @param \AppBundle\Entity\Distribution_module_teacher $distributionsModuleTeacher
     *
     * @return School_group
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

    /**
     * Add student
     *
     * @param \AppBundle\Entity\Student $student
     *
     * @return School_group
     */
    public function addStudent(\AppBundle\Entity\Student $student)
    {
        $this->students[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \AppBundle\Entity\Student $student
     */
    public function removeStudent(\AppBundle\Entity\Student $student)
    {
        $this->students->removeElement($student);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add studentsGroup
     *
     * @param \AppBundle\Entity\Student $studentsGroup
     *
     * @return School_group
     */
    public function addStudentsGroup(\AppBundle\Entity\Student $studentsGroup)
    {
        $this->students_groups[] = $studentsGroup;

        return $this;
    }

    /**
     * Remove studentsGroup
     *
     * @param \AppBundle\Entity\Student $studentsGroup
     */
    public function removeStudentsGroup(\AppBundle\Entity\Student $studentsGroup)
    {
        $this->students_groups->removeElement($studentsGroup);
    }

    /**
     * Get studentsGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudentsGroups()
    {
        return $this->students_groups;
    }
}
