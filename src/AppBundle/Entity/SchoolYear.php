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
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="curse", type="string", length=255)
     */
    private $curse;


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
     * Set curse
     *
     * @param string $curse
     *
     * @return SchoolYear
     */
    public function setCurse($curse)
    {
        $this->curse = $curse;

        return $this;
    }

    /**
     * Get curse
     *
     * @return string
     */
    public function getCurse()
    {
        return $this->curse;
    }
}
