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
     * @ORM\Column(name="name", type="string")
     */
    private $name;


    /**
     * @ORM\Column(name="initials", type="string", unique=true)
     */
    private $initials;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cycle", inversedBy="school_groups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cycle;

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
}
