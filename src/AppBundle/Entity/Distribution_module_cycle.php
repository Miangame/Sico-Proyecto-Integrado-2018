<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Distribution_module_cycle
 *
 * @ORM\Table(name="Distribution_module_cycle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Distribution_module_cycleRepository")
 */
class Distribution_module_cycle
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
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="distributions_module_cycle")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false)
     */
    protected $module;

    /**
     * @ORM\ManyToOne(targetEntity="Cycle", inversedBy="distributions_module_cycle")
     * @ORM\JoinColumn(name="cycle_id", referencedColumnName="id", nullable=false)
     */
    protected $cycle;


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
     * @param \AppBundle\Entity\Module $module
     *
     * @return Distribution_module_cycle
     */
    public function setModule(\AppBundle\Entity\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \AppBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set cycle
     *
     * @param \AppBundle\Entity\Cycle $cycle
     *
     * @return Distribution_module_cycle
     */
    public function setCycle(\AppBundle\Entity\Cycle $cycle = null)
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
