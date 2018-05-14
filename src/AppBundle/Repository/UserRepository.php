<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\User;

class UserRepository extends EntityRepository
{
    public function getUsers()
    {
        return $this->findAll();
    }
}
