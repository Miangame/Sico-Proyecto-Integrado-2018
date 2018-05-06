<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Request_company
 *
 * @ORM\Table(name="Request_company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Request_companyRepository")
 */
class Request_company
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name_company", type="string")
     */
    private $name_company;

    /**
     * @ORM\Column(name="cif", type="string")
     */
    private $cif;

    /**
     * @ORM\Column(name="headquarters_of_work", type="string")
     */
    private $headquarters_of_work;

    /**
     * @ORM\Column(name="headquarters_principal", type="string")
     */
    private $headquarters_principal;

    /**
     * @ORM\Column(name="contact_person", type="string")
     */
    private $contact_person;

    /**
     * @ORM\Column(name="email", type="string")
     */
    private $email;

    /**
     * @ORM\Column(name="phone", type="string")
     */
    private $phone;

    /**
     * @ORM\Column(name="manager", type="string")
     */
    private $manager;

    /**
     * @ORM\Column(name="nif_manager", type="string")
     */
    private $nif_manager;


    /**
     * @ORM\Column(name="tutor", type="string")
     */
    private $tutor;

    /**
     * @ORM\Column(name="nif_tutor", type="string")
     */
    private $nif_tutor;

    /**
     * @ORM\Column(name="number_of_daw", type="integer")
     */
    private $number_of_daw;

    /**
     * @ORM\Column(name="number_of_asir", type="integer")
     */
    private $number_of_asir;

    /**
     * @ORM\Column(name="type_of_work_day", type="string")
     */
    private $type_of_work_day;

    /**
     * @ORM\Column(name="tasks_to_be_done", type="string")
     */
    private $tasks_to_be_done;

    /**
     * @ORM\Column(name="observations", type="string")
     */
    private $observations;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolYear", inversedBy="request_companies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schoolYear;

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
     * Set nameCompany
     *
     * @param string $nameCompany
     *
     * @return Request_company
     */
    public function setNameCompany($nameCompany)
    {
        $this->name_company = $nameCompany;

        return $this;
    }

    /**
     * Get nameCompany
     *
     * @return string
     */
    public function getNameCompany()
    {
        return $this->name_company;
    }

    /**
     * Set cif
     *
     * @param string $cif
     *
     * @return Request_company
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
     * Set headquartersOfWork
     *
     * @param string $headquartersOfWork
     *
     * @return Request_company
     */
    public function setHeadquartersOfWork($headquartersOfWork)
    {
        $this->headquarters_of_work = $headquartersOfWork;

        return $this;
    }

    /**
     * Get headquartersOfWork
     *
     * @return string
     */
    public function getHeadquartersOfWork()
    {
        return $this->headquarters_of_work;
    }

    /**
     * Set headquartersPrincipal
     *
     * @param string $headquartersPrincipal
     *
     * @return Request_company
     */
    public function setHeadquartersPrincipal($headquartersPrincipal)
    {
        $this->headquarters_principal = $headquartersPrincipal;

        return $this;
    }

    /**
     * Get headquartersPrincipal
     *
     * @return string
     */
    public function getHeadquartersPrincipal()
    {
        return $this->headquarters_principal;
    }

    /**
     * Set contactPerson
     *
     * @param string $contactPerson
     *
     * @return Request_company
     */
    public function setContactPerson($contactPerson)
    {
        $this->contact_person = $contactPerson;

        return $this;
    }

    /**
     * Get contactPerson
     *
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contact_person;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Request_company
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
     * Set phone
     *
     * @param string $phone
     *
     * @return Request_company
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
     * Set manager
     *
     * @param string $manager
     *
     * @return Request_company
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return string
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set nifManager
     *
     * @param string $nifManager
     *
     * @return Request_company
     */
    public function setNifManager($nifManager)
    {
        $this->nif_manager = $nifManager;

        return $this;
    }

    /**
     * Get nifManager
     *
     * @return string
     */
    public function getNifManager()
    {
        return $this->nif_manager;
    }

    /**
     * Set tutor
     *
     * @param string $tutor
     *
     * @return Request_company
     */
    public function setTutor($tutor)
    {
        $this->tutor = $tutor;

        return $this;
    }

    /**
     * Get tutor
     *
     * @return string
     */
    public function getTutor()
    {
        return $this->tutor;
    }

    /**
     * Set nifTutor
     *
     * @param string $nifTutor
     *
     * @return Request_company
     */
    public function setNifTutor($nifTutor)
    {
        $this->nif_tutor = $nifTutor;

        return $this;
    }

    /**
     * Get nifTutor
     *
     * @return string
     */
    public function getNifTutor()
    {
        return $this->nif_tutor;
    }

    /**
     * Set numberOfDaw
     *
     * @param integer $numberOfDaw
     *
     * @return Request_company
     */
    public function setNumberOfDaw($numberOfDaw)
    {
        $this->number_of_daw = $numberOfDaw;

        return $this;
    }

    /**
     * Get numberOfDaw
     *
     * @return integer
     */
    public function getNumberOfDaw()
    {
        return $this->number_of_daw;
    }

    /**
     * Set numberOfAsir
     *
     * @param integer $numberOfAsir
     *
     * @return Request_company
     */
    public function setNumberOfAsir($numberOfAsir)
    {
        $this->number_of_asir = $numberOfAsir;

        return $this;
    }

    /**
     * Get numberOfAsir
     *
     * @return integer
     */
    public function getNumberOfAsir()
    {
        return $this->number_of_asir;
    }

    /**
     * Set typeOfWorkDay
     *
     * @param string $typeOfWorkDay
     *
     * @return Request_company
     */
    public function setTypeOfWorkDay($typeOfWorkDay)
    {
        $this->type_of_work_day = $typeOfWorkDay;

        return $this;
    }

    /**
     * Get typeOfWorkDay
     *
     * @return string
     */
    public function getTypeOfWorkDay()
    {
        return $this->type_of_work_day;
    }

    /**
     * Set tasksToBeDone
     *
     * @param string $tasksToBeDone
     *
     * @return Request_company
     */
    public function setTasksToBeDone($tasksToBeDone)
    {
        $this->tasks_to_be_done = $tasksToBeDone;

        return $this;
    }

    /**
     * Get tasksToBeDone
     *
     * @return string
     */
    public function getTasksToBeDone()
    {
        return $this->tasks_to_be_done;
    }

    /**
     * Set observations
     *
     * @param string $observations
     *
     * @return Request_company
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get observations
     *
     * @return string
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set schoolYear
     *
     * @param \AppBundle\Entity\SchoolYear $schoolYear
     *
     * @return Request_company
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
}
