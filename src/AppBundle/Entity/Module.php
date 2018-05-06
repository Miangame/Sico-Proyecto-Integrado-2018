<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="Module")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleRepository")
 */
class Module
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
     * @ORM\Column(name="hours", type="integer", nullable=false)
     */
    private $hours;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_module_cycle", mappedBy="module")
     */
    private $distributions_module_cycle;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_module_teacher", mappedBy="module")
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
     * @return Module
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
     * @return Module
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
     * Set hours
     *
     * @param integer $hours
     *
     * @return Module
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
     * Constructor
     */
    public function __construct()
    {
        $this->distributions_module_cycle = new \Doctrine\Common\Collections\ArrayCollection();
        $this->distributions_module_teacher = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add distributionsModuleCycle
     *
     * @param \AppBundle\Entity\Distribution_module_cycle $distributionsModuleCycle
     *
     * @return Module
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

    /**
     * Add distributionsModuleTeacher
     *
     * @param \AppBundle\Entity\Distribution_module_teacher $distributionsModuleTeacher
     *
     * @return Module
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
}
