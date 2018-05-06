<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Distribution_company
 *
 * @ORM\Table(name="Distribution_company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Distribution_companyRepository")
 */
class Distribution_company
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Distribution_company")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="Distribution_company")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Distribution_company")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\Column(name="assessment_student", type="integer")
     */
    private $assessment_student;

    /**
     * @ORM\Column(name="assessment_teacher", type="integer")
     */
    private $assessment_teacher;

    /**
     * @ORM\Column(name="observation_student", type="text")
     */
    private $observation_student;

    /**
     * @ORM\Column(name="observation_teacher", type="text")
     */
    private $observation_teacher;




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
     * Set assessmentStudent
     *
     * @param integer $assessmentStudent
     *
     * @return Distribution_company
     */
    public function setAssessmentStudent($assessmentStudent)
    {
        $this->assessment_student = $assessmentStudent;

        return $this;
    }

    /**
     * Get assessmentStudent
     *
     * @return integer
     */
    public function getAssessmentStudent()
    {
        return $this->assessment_student;
    }

    /**
     * Set assessmentTeacher
     *
     * @param integer $assessmentTeacher
     *
     * @return Distribution_company
     */
    public function setAssessmentTeacher($assessmentTeacher)
    {
        $this->assessment_teacher = $assessmentTeacher;

        return $this;
    }

    /**
     * Get assessmentTeacher
     *
     * @return integer
     */
    public function getAssessmentTeacher()
    {
        return $this->assessment_teacher;
    }

    /**
     * Set observationStudent
     *
     * @param string $observationStudent
     *
     * @return Distribution_company
     */
    public function setObservationStudent($observationStudent)
    {
        $this->observation_student = $observationStudent;

        return $this;
    }

    /**
     * Get observationStudent
     *
     * @return string
     */
    public function getObservationStudent()
    {
        return $this->observation_student;
    }

    /**
     * Set observationTeacher
     *
     * @param string $observationTeacher
     *
     * @return Distribution_company
     */
    public function setObservationTeacher($observationTeacher)
    {
        $this->observation_teacher = $observationTeacher;

        return $this;
    }

    /**
     * Get observationTeacher
     *
     * @return string
     */
    public function getObservationTeacher()
    {
        return $this->observation_teacher;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Distribution_company
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set student
     *
     * @param \AppBundle\Entity\Student $student
     *
     * @return Distribution_company
     */
    public function setStudent(\AppBundle\Entity\Student $student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \AppBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     *
     * @return Distribution_company
     */
    public function setCompany(\AppBundle\Entity\Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}
