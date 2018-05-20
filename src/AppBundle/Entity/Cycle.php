<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cycle
 *
 * @ORM\Table(name="Cycle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CycleRepository")
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
     * @Assert\Range(
     *      min = 1,
     *      max = 30,
     *      minMessage = "No puede tener menos de {{ limit }} hora a la semana",
     *      maxMessage = "No puede tener más de {{ limit }} horas a la semana"
     * )
     * @ORM\Column(name="hours", type="integer", nullable=false)
     */
    private $hours;

    /**
     * @ORM\OneToMany(targetEntity="School_group", mappedBy="cycle")
     */
    private $school_groups;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="cycle")
     */
    private $modules_cycles;

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
     * Add schoolGroup
     *
     * @param \AppBundle\Entity\School_group $schoolGroup
     *
     * @return Cycle
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
}
