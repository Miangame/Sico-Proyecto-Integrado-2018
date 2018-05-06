<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchoolYear_convocatory
 *
 * @ORM\Table(name="School_year_convocatory")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolYear_convocatoryRepository")
 */
class SchoolYear_convocatory
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
     * @ORM\ManyToOne(targetEntity="SchoolYear", inversedBy="schoolYear_convocatories")
     * @ORM\JoinColumn(name="schoolYear_id", referencedColumnName="id")
     */
    protected $schoolYear;

    /**
     * @ORM\ManyToOne(targetEntity="Convocatory", inversedBy="schoolYear_convocatories")
     * @ORM\JoinColumn(name="convocatory_id", referencedColumnName="id")
     */
    protected $convocatory;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="schoolYear_convocatory")
     */
    private $students;

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
     * Set schoolYear
     *
     * @param \AppBundle\Entity\SchoolYear $schoolYear
     *
     * @return SchoolYear_convocatory
     */
    public function setSchoolYear(\AppBundle\Entity\SchoolYear $schoolYear = null)
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
     * Set convocatory
     *
     * @param \AppBundle\Entity\Convocatory $convocatory
     *
     * @return SchoolYear_convocatory
     */
    public function setConvocatory(\AppBundle\Entity\Convocatory $convocatory = null)
    {
        $this->convocatory = $convocatory;

        return $this;
    }

    /**
     * Get convocatory
     *
     * @return \AppBundle\Entity\Convocatory
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
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add student
     *
     * @param \AppBundle\Entity\Student $student
     *
     * @return SchoolYear_convocatory
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
