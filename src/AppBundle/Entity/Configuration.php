<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration
 *
 * @ORM\Table(name="configuration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfigurationRepository")
 */
class Configuration
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="weight_pi", type="integer", nullable=false)
     */
    private $weight_pi;

    /**
     * @ORM\Column(name="weight_fct", type="integer", nullable=false)
     */
    private $weight_fct;

    /**
     * @ORM\Column(name="hours_first", type="boolean", nullable=false)
     */
    private $hours_first;

    /**
     * @ORM\Column(name="hours_secondary", type="boolean", nullable=false)
     */
    private $hours_secondary;

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
     * Set weightPi
     *
     * @param integer $weightPi
     *
     * @return Configuration
     */
    public function setWeightPi($weightPi)
    {
        $this->weight_pi = $weightPi;

        return $this;
    }

    /**
     * Get weightPi
     *
     * @return integer
     */
    public function getWeightPi()
    {
        return $this->weight_pi;
    }

    /**
     * Set weightFct
     *
     * @param integer $weightFct
     *
     * @return Configuration
     */
    public function setWeightFct($weightFct)
    {
        $this->weight_fct = $weightFct;

        return $this;
    }

    /**
     * Get weightFct
     *
     * @return integer
     */
    public function getWeightFct()
    {
        return $this->weight_fct;
    }

    /**
     * Set hoursFirst
     *
     * @param boolean $hoursFirst
     *
     * @return Configuration
     */
    public function setHoursFirst($hoursFirst)
    {
        $this->hours_first = $hoursFirst;

        return $this;
    }

    /**
     * Get hoursFirst
     *
     * @return boolean
     */
    public function getHoursFirst()
    {
        return $this->hours_first;
    }

    /**
     * Set hoursSecondary
     *
     * @param boolean $hoursSecondary
     *
     * @return Configuration
     */
    public function setHoursSecondary($hoursSecondary)
    {
        $this->hours_secondary = $hoursSecondary;

        return $this;
    }

    /**
     * Get hoursSecondary
     *
     * @return boolean
     */
    public function getHoursSecondary()
    {
        return $this->hours_secondary;
    }
}
