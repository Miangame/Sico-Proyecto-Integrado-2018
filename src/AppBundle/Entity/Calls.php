<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calls
 *
 * @ORM\Table(name="calls")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CallsRepository")
 */
class Calls
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
     * @ORM\Column(name="calls", type="string", length=255)
     */
    private $calls;


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
     * Set calls
     *
     * @param string $calls
     *
     * @return Calls
     */
    public function setCalls($calls)
    {
        $this->calls = $calls;

        return $this;
    }

    /**
     * Get calls
     *
     * @return string
     */
    public function getCalls()
    {
        return $this->calls;
    }
}

