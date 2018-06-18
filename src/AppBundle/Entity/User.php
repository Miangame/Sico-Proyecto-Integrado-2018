<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="User")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * @ORM\HasLifecycleCallbacks()
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
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    protected $first_name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    protected $last_name;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $to_distribute;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_project", mappedBy="user")
     */
    private $distribution_project;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_company", mappedBy="user")
     */
    private $distribution_company;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_module_teacher", mappedBy="teacher")
     */
    private $distributions_module_teacher;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $img;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $current_convocatory;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $first_login;

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

    /**
     * Add distributionsModuleTeacher
     *
     * @param \AppBundle\Entity\Distribution_module_teacher $distributionsModuleTeacher
     *
     * @return User
     */
    public function addDistributionsModuleTeacher(\AppBundle\Entity\Distribution_module_teacher $distributionsModuleTeacher)
    {
        $this->distributions_module_teacher[] = $distributionsModuleTeacher;

        return $this;
    }

    /**
     * Remove distributionsModuleTeacher
     *
     * @param \AppBundle\Entity\Distribution_module_teacher $distributionsModuleTeacher
     */
    public function removeDistributionsModuleTeacher(\AppBundle\Entity\Distribution_module_teacher $distributionsModuleTeacher)
    {
        $this->distributions_module_teacher->removeElement($distributionsModuleTeacher);
    }

    /**
     * Get distributionsModuleTeacher
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDistributionsModuleTeacher()
    {
        return $this->distributions_module_teacher;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
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
     * @return User
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
     * Set img
     *
     * @param string $img
     *
     * @return User
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set toDistribute
     *
     * @param boolean $toDistribute
     *
     * @return User
     */
    public function setToDistribute($toDistribute)
    {
        $this->to_distribute = $toDistribute;

        return $this;
    }

    /**
     * Get toDistribute
     *
     * @return boolean
     */
    public function getToDistribute()
    {
        return $this->to_distribute;
    }

    public function __toString()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * Set currentConvocatory
     *
     * @param integer $currentConvocatory
     *
     * @return User
     */
    public function setCurrentConvocatory($currentConvocatory)
    {
        $this->current_convocatory = $currentConvocatory;

        return $this;
    }

    /**
     * Get currentConvocatory
     *
     * @return integer
     */
    public function getCurrentConvocatory()
    {
        return $this->current_convocatory;
    }

    /**
     * Set firstLogin
     *
     * @param boolean $firstLogin
     *
     * @return User
     */
    public function setFirstLogin($firstLogin)
    {
        $this->first_login = $firstLogin;

        return $this;
    }

    /**
     * Get firstLogin
     *
     * @return boolean
     */
    public function getFirstLogin()
    {
        return $this->first_login;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersistUser(LifecycleEventArgs $args)
    {
        $this->setFirstLogin(1);
    }
}
