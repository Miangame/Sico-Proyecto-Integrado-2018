<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calls
 *
 * @ORM\Table(name="Convocatory")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConvocatoryRepository")
 */
class Convocatory
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="convocatory", type="string", length=255, nullable=false)
     */
    private $convocatory;

    /**
     * @ORM\OneToMany(targetEntity="SchoolYear_convocatory", mappedBy="convocatory")
     */
    private $schoolYear_convocatories;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set convocatory
     *
     * @param string $convocatory
     *
     * @return Convocatory
     */
    public function setConvocatory($convocatory)
    {
        $this->convocatory = $convocatory;

        return $this;
    }

    /**
     * Get convocatory
     *
     * @return string
     */
    public function getConvocatory()
    {
        return $this->convocatory;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schoolYear_convocatories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add schoolYearConvocatory
     *
     * @param \AppBundle\Entity\SchoolYear_convocatory $schoolYearConvocatory
     *
     * @return Convocatory
     */
    public function addSchoolYearConvocatory(\AppBundle\Entity\SchoolYear_convocatory $schoolYearConvocatory)
    {
        $this->schoolYear_convocatories[] = $schoolYearConvocatory;

        return $this;
    }

    /**
     * Remove schoolYearConvocatory
     *
     * @param \AppBundle\Entity\SchoolYear_convocatory $schoolYearConvocatory
     */
    public function removeSchoolYearConvocatory(\AppBundle\Entity\SchoolYear_convocatory $schoolYearConvocatory)
    {
        $this->schoolYear_convocatories->removeElement($schoolYearConvocatory);
    }

    /**
     * Get schoolYearConvocatories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSchoolYearConvocatories()
    {
        return $this->schoolYear_convocatories;
    }

    public function __toString()
    {
        return $this->convocatory;
    }
}
