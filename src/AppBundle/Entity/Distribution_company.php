<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Distribution_company
 *
 * @UniqueEntity("student")
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
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="User", inversedBy="distribution_company")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="distribution_company")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $student;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="distribution_company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $company;

    /**
     * @ORM\Column(name="assessment_student", type="integer", nullable=true)
     */
    private $assessment_student;

    /**
     * @ORM\Column(name="assessment_teacher", type="integer", nullable=true)
     */
    private $assessment_teacher;

    /**
     * @ORM\Column(name="observation_student", type="text", nullable=true)
     */
    private $observation_student;

    /**
     * @ORM\Column(name="observation_teacher", type="text", nullable=true)
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

    public function __toString()
    {
        return $this->getStudent().' / '.$this->getCompany();
    }
}
