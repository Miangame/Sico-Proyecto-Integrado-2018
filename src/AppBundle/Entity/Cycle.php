<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="hours", type="integer")
     */
    private $hours;

    /**
     * @ORM\OneToMany(targetEntity="School_group", mappedBy="cycle")
     */
    private $school_groups;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_module_cycle", mappedBy="cycle")
     */
    private $distributions_module_cycle;

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
     * Add distributionsModuleCycle
     *
     * @param \AppBundle\Entity\Distribution_module_cycle $distributionsModuleCycle
     *
     * @return Cycle
     */
    public function addDistributionsModuleCycle(\AppBundle\Entity\Distribution_module_cycle $distributionsModuleCycle)
    {
        $this->distributions_module_cycle[] = $distributionsModuleCycle;

        return $this;
    }

    /**
     * Remove distributionsModuleCycle
     *
     * @param \AppBundle\Entity\Distribution_module_cycle $distributionsModuleCycle
     */
    public function removeDistributionsModuleCycle(\AppBundle\Entity\Distribution_module_cycle $distributionsModuleCycle)
    {
        $this->distributions_module_cycle->removeElement($distributionsModuleCycle);
    }

    /**
     * Get distributionsModuleCycle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDistributionsModuleCycle()
    {
        return $this->distributions_module_cycle;
    }
}
