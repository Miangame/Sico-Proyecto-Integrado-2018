<?php

namespace AppBundle\Repository;

/**
 * CycleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CycleRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCycles()
    {
        return $this->findAll();
    }
}
