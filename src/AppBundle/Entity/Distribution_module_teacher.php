<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Distribution_module_teacher
 *
 * @ORM\Table(name="Distribution_module_teacher")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Distribution_module_teacherRepository")
 */
class Distribution_module_teacher
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
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="distributions_module_teacher")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     */
    protected $module;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="distributions_module_teacher")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="School_group", inversedBy="distributions_module_teacher")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolYear", inversedBy="distributions_module_teacher")
     * @ORM\JoinColumn(name="schoolYear_id", referencedColumnName="id")
     */
    protected $schoolYear;


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
     * Set module
     *
     * @param \AppBundle\Entity\Module $module
     *
     * @return Distribution_module_teacher
     */
    public function setModule(\AppBundle\Entity\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \AppBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set teacher
     *
     * @param \AppBundle\Entity\User $teacher
     *
     * @return Distribution_module_teacher
     */
    public function setTeacher(\AppBundle\Entity\User $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \AppBundle\Entity\User
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set group
     *
     * @param \AppBundle\Entity\School_group $group
     *
     * @return Distribution_module_teacher
     */
    public function setGroup(\AppBundle\Entity\School_group $group = null)
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

    /**
     * Set schoolYear
     *
     * @param \AppBundle\Entity\SchoolYear $schoolYear
     *
     * @return Distribution_module_teacher
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
}
