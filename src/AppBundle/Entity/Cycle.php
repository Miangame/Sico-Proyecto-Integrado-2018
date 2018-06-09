<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Cycle
 *
 * @ORM\Table(name="Cycle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CycleRepository")
 * @UniqueEntity("name")
 * @UniqueEntity("initials")
 */
class Cycle
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="initials", type="string", nullable=false)
     */
    private $initials;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Las horas no deben ser menos de {{ limit }}",
     * )
     * @ORM\Column(name="titularHours1", type="integer", nullable=false)
     */
    private $titularHours1;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Las horas no deben ser menos de {{ limit }}",
     * )
     * @ORM\Column(name="desdobleHours1", type="integer", nullable=false)
     */
    private $desdobleHours1;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Las horas no deben ser menos de {{ limit }}",
     * )
     * @ORM\Column(name="titularHours2", type="integer", nullable=false)
     */
    private $titularHours2;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Las horas no deben ser menos de {{ limit }}",
     * )
     * @ORM\Column(name="desdobleHours2", type="integer", nullable=false)
     */
    private $desdobleHours2;

    /**
     * @ORM\OneToMany(targetEntity="Course_cycle", mappedBy="cycle")
     */
    private $courses_cycles;

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
        $this->school_groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set hours
     *
     * @param integer $hours
     *
     * @return Cycle
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get hours
     *
     * @return integer
     */
    public function getHours()
    {
        return $this->hours;
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
     * Set name
     *
     * @param string $name
     *
     * @return Cycle
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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add modulesCycle
     *
     * @param \AppBundle\Entity\Module $modulesCycle
     *
     * @return Cycle
     */
    public function addModulesCycle(\AppBundle\Entity\Module $modulesCycle)
    {
        $this->modules_cycles[] = $modulesCycle;

        return $this;
    }

    /**
     * Remove modulesCycle
     *
     * @param \AppBundle\Entity\Module $modulesCycle
     */
    public function removeModulesCycle(\AppBundle\Entity\Module $modulesCycle)
    {
        $this->modules_cycles->removeElement($modulesCycle);
    }

    /**
     * Get modulesCycles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModulesCycles()
    {
        return $this->modules_cycles;
    }

    /**
     * Set titularHours1
     *
     * @param integer $titularHours1
     *
     * @return Cycle
     */
    public function setTitularHours1($titularHours1)
    {
        $this->titularHours1 = $titularHours1;

        return $this;
    }

    /**
     * Get titularHours1
     *
     * @return integer
     */
    public function getTitularHours1()
    {
        return $this->titularHours1;
    }

    /**
     * Set desdobleHours1
     *
     * @param integer $desdobleHours1
     *
     * @return Cycle
     */
    public function setDesdobleHours1($desdobleHours1)
    {
        $this->desdobleHours1 = $desdobleHours1;

        return $this;
    }

    /**
     * Get desdobleHours1
     *
     * @return integer
     */
    public function getDesdobleHours1()
    {
        return $this->desdobleHours1;
    }

    /**
     * Set titularHours2
     *
     * @param integer $titularHours2
     *
     * @return Cycle
     */
    public function setTitularHours2($titularHours2)
    {
        $this->titularHours2 = $titularHours2;

        return $this;
    }

    /**
     * Get titularHours2
     *
     * @return integer
     */
    public function getTitularHours2()
    {
        return $this->titularHours2;
    }

    /**
     * Set desdobleHours2
     *
     * @param integer $desdobleHours2
     *
     * @return Cycle
     */
    public function setDesdobleHours2($desdobleHours2)
    {
        $this->desdobleHours2 = $desdobleHours2;

        return $this;
    }

    /**
     * Get desdobleHours2
     *
     * @return integer
     */
    public function getDesdobleHours2()
    {
        return $this->desdobleHours2;
    }

    /**
     * Set initials
     *
     * @param string $initials
     *
     * @return Cycle
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
     * Add coursesCycle
     *
     * @param \AppBundle\Entity\Course_cycle $coursesCycle
     *
     * @return Cycle
     */
    public function addCoursesCycle(\AppBundle\Entity\Course_cycle $coursesCycle)
    {
        $this->courses_cycles[] = $coursesCycle;

        return $this;
    }

    /**
     * Remove coursesCycle
     *
     * @param \AppBundle\Entity\Course_cycle $coursesCycle
     */
    public function removeCoursesCycle(\AppBundle\Entity\Course_cycle $coursesCycle)
    {
        $this->courses_cycles->removeElement($coursesCycle);
    }

    /**
     * Get coursesCycles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCoursesCycles()
    {
        return $this->courses_cycles;
    }
}
