<?php

namespace AppBundle\Repository;

/**
 * Distribution_projectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Distribution_projectRepository extends \Doctrine\ORM\EntityRepository
{
    public function getDistribution(){
        return $this->findAll();
    }
}
