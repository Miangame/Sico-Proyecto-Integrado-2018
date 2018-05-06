<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Rol", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rol;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_project", mappedBy="user")
     */
    private $distribution_project;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_company", mappedBy="user")
     */
    private $distribution_company;


    /**
     * Set rol
     *
     * @param \AppBundle\Entity\Rol $rol
     *
     * @return User
     */
    public function setRol(\AppBundle\Entity\Rol $rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \AppBundle\Entity\Rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Add distributionProject
     *
     * @param \AppBundle\Entity\Distribution_project $distributionProject
     *
     * @return User
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
     * @return User
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
}
