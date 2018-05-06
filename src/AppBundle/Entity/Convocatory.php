<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calls
 *
 * @ORM\Table(name="Convocatory")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConvocatoryRepository")
 */
class Convocatory
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="convocatory", type="string", length=255)
     */
    private $convocatory;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set convocatory
     *
     * @param string $convocatory
     *
     * @return Convocatory
     */
    public function setConvocatory($convocatory)
    {
        $this->convocatory = $convocatory;

        return $this;
    }

    /**
     * Get convocatory
     *
     * @return string
     */
    public function getConvocatory()
    {
        return $this->convocatory;
    }
}
