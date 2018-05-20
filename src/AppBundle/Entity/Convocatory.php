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
     * @ORM\Column(name="convocatory", type="string", length=255,
     *     columnDefinition="ENUM('MARZO', 'SEPTIEMBRE')", nullable=false)
     */
    private $convocatory;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolYear", inversedBy="convocatories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schoolYear;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="convocatory")
     */
    private $students;

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

    /**
     * Set schoolYear
     *
     * @param \AppBundle\Entity\SchoolYear $schoolYear
     *
     * @return Convocatory
     */
    public function setSchoolYear(\AppBundle\Entity\SchoolYear $schoolYear)
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }

    /**
     * Get schoolYear
     *
     * @return \AppBundle\Entity\SchoolYear
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }

    /**
     * Add student
     *
     * @param \AppBundle\Entity\Student $student
     *
     * @return Convocatory
     */
    public function addStudent(\AppBundle\Entity\Student $student)
    {
        $this->students[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \AppBundle\Entity\Student $student
     */
    public function removeStudent(\AppBundle\Entity\Student $student)
    {
        $this->students->removeElement($student);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }
}
