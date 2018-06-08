<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Company
 * @UniqueEntity("cif")
 * @UniqueEntity("name")
 * @ORM\Table(name="Company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="name", type="string", nullable=false, unique=true)
     */
    private $name;

    /**
     * @Assert\Regex("/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/i")
     * @Assert\NotBlank()
     * @ORM\Column(name="cif", type="string", nullable=false, unique=true)
     */
    private $cif;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^[0-9]{9}$/")
     * @ORM\Column(name="phone", type="string")
     */
    private $phone;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/([\w\.\-_]+)?\w+@[\w-_]+(\.\w+){1,}/")
     * @ORM\Column(name="email", type="string")
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Distribution_company", mappedBy="company")
     */
    private $distribution_company;

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
     * Set name
     *
     * @param string $name
     *
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cif
     *
     * @param string $cif
     *
     * @return Company
     */
    public function setCif($cif)
    {
        $this->cif = $cif;

        return $this;
    }

    /**
     * Get cif
     *
     * @return string
     */
    public function getCif()
    {
        return $this->cif;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Company
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Company
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->distribution_company = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add distributionCompany
     *
     * @param \AppBundle\Entity\Distribution_company $distributionCompany
     *
     * @return Company
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

    public function __toString()
    {
        return $this->getName().'--'.$this->getCif();
    }
}
