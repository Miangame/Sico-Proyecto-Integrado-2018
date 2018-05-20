<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Student
 *
 * @ORM\Table(name="Student")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="first_name", type="string", nullable=false)
     */
    private $first_name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="last_name", type="string", nullable=false)
     */
    private $last_name;

    /**
     * @ORM\ManyToOne(targetEntity="School_group", inversedBy="students_groups", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $group;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_project", mappedBy="student")
     */
    private $distribution_project;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_company", mappedBy="student")
     */
    private $distribution_company;


    /**
     * @ORM\ManyToOne(targetEntity="Convocatory", inversedBy="students")
     * @ORM\JoinColumn(nullable=false)
     */
    private $convocatory;

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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Student
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Student
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->distribution_project = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add distributionProject
     *
     * @param \AppBundle\Entity\Distribution_project $distributionProject
     *
     * @return Student
     */
    public function addDistributionProject(\AppBundle\Entity\Distribution_project $distributionProject)
    {
        $this->distribution_project[] = $distributionProject;

        return $this;
    }

    /**
     * Remove distributionProject
     *
     * @param \AppBundle\Entity\Distribution_project $distributionProject
     */
    public function removeDistributionProject(\AppBundle\Entity\Distribution_project $distributionProject)
    {
        $this->distribution_project->removeElement($distributionProject);
    }

    /**
     * Get distributionProject
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDistributionProject()
    {
        return $this->distribution_project;
    }

    /**
     * Add distributionCompany
     *
     * @param \AppBundle\Entity\Distribution_company $distributionCompany
     *
     * @return Student
     */
    public function addDistributionCompany(\AppBundle\Entity\Distribution_company $distributionCompany)
    {
        $this->distribution_company[] = $distributionCompany;

        return $this;
    }

    /**
     * Remove distributionCompany
     *
     * @param \AppBundle\Entity\Distribution_company $distributionCompany
     */
    public function removeDistributionCompany(\AppBundle\Entity\Distribution_company $distributionCompany)
    {
        $this->distribution_company->removeElement($distributionCompany);
    }

    /**
     * Get distributionCompany
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDistributionCompany()
    {
        return $this->distribution_company;
    }

    /**
     * Set groupId
     *
     * @param \AppBundle\Entity\School_group $groupId
     *
     * @return Student
     */
    public function setGroupId(\AppBundle\Entity\School_group $groupId)
    {
        $this->group = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return \AppBundle\Entity\School_group
     */
    public function getGroupId()
    {
        return $this->group;
    }

    /**
     * Set group
     *
     * @param \AppBundle\Entity\School_group $group
     *
     * @return Student
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

    public function __toString()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * Set convocatory
     *
     * @param \AppBundle\Entity\Convocatory $convocatory
     *
     * @return Student
     */
    public function setConvocatory(\AppBundle\Entity\Convocatory $convocatory)
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
}
