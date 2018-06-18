<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManager;

class AppFixtures extends Fixture
{
    private $fosUser = null;

    public function __construct(UserManager $userManager)
    {
        $this->fosUser = $userManager;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->fosUser->createUser();
        $userManager->setUsername('admin');
        $userManager->setEmail('admin@admin.com');
        $userManager->setToDistribute(0);
        $userManager->setRoles(Array('ROLE_ADMIN'));
        $userManager->setEnabled(true);
        $userManager->setFirstName('admin');
        $userManager->setLastName('admin');
        $userManager->setPlainPassword('admin');
        $this->fosUser->updateUser($userManager, true);

    }
}