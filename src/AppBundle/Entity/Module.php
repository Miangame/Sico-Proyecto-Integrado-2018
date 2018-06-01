<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="initials", type="string", unique=true, nullable=false)
     */
    private $initials;

    /**
     * @ORM\ManyToOne(targetEntity="School_group", inversedBy="modules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $group;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      minMessage = "No puede tener menos de {{ limit }} hora a la semana",
     * )
     * @ORM\Column(name="hours", type="integer", nullable=false)
     */
    private $hours;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "No puede tener menos de {{ limit }} hora a la semana",
     * )
     * @ORM\Column(name="hoursDesdoble", type="integer", nullable=false)
     */
    private $hoursDesdoble;

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

    public function __toString()
    {
        return $this->getInitials();
    }

    /**
     * Set hoursDesdoble
     *
     * @param integer $hoursDesdoble
     *
     * @return Module
     */
    public function setHoursDesdoble($hoursDesdoble)
    {
        $this->hoursDesdoble = $hoursDesdoble;

        return $this;
    }

    /**
     * Get hoursDesdoble
     *
     * @return integer
     */
    public function getHoursDesdoble()
    {
        return $this->hoursDesdoble;
    }

    /**
     * Set group
     *
     * @param \AppBundle\Entity\School_group $group
     *
     * @return Module
     */
    public function setGroup(\AppBundle\Entity\School_group $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AppBundle\Entity\School_group
     */
    public function getGroup()
    {
        return $this->group;
    }
}
