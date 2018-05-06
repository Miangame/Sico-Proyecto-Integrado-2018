<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchoolYear
 *
 * @ORM\Table(name="school_year")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolYearRepository")
 */
class SchoolYear
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="course", type="string", length=255)
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="Request_company", mappedBy="schoolYear")
     */
    private $request_companies;

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
     * Constructor
     */
    public function __construct()
    {
        $this->request_companies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set course
     *
     * @param string $course
     *
     * @return SchoolYear
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return string
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Add requestCompany
     *
     * @param \AppBundle\Entity\Request_company $requestCompany
     *
     * @return SchoolYear
     */
    public function addRequestCompany(\AppBundle\Entity\Request_company $requestCompany)
    {
        $this->request_companies[] = $requestCompany;

        return $this;
    }

    /**
     * Remove requestCompany
     *
     * @param \AppBundle\Entity\Request_company $requestCompany
     */
    public function removeRequestCompany(\AppBundle\Entity\Request_company $requestCompany)
    {
        $this->request_companies->removeElement($requestCompany);
    }

    /**
     * Get requestCompanies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequestCompanies()
    {
        return $this->request_companies;
    }
}
