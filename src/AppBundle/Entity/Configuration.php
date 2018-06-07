<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      minMessage = "El peso debe ser al menos {{ limit }}"
     *     )
     * @ORM\Column(name="weight_pi", type="integer", nullable=false)
     */
    private $weight_pi;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      minMessage = "El peso debe ser al menos {{ limit }}"
     *     )
     * @ORM\Column(name="weight_fct", type="integer", nullable=false)
     */
    private $weight_fct;


    /**
     * @ORM\Column(name="organization_name", type="string", nullable=true)
     */
    private $organization_name;

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

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Configuration
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set organizationName
     *
     * @param string $organizationName
     *
     * @return Configuration
     */
    public function setOrganizationName($organizationName)
    {
        $this->organization_name = $organizationName;

        return $this;
    }

    /**
     * Get organizationName
     *
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->organization_name;
    }
}
