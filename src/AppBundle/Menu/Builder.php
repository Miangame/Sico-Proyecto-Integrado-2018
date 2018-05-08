<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;


class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        if ($this->container->get('security.authorization_checker')->isGranted("ROLE_ADMIN")) {
            $menu->addChild('Admin', array('route' => ''))
                ->setAttribute('icon', 'fa fa-money');
        } else if ($this->container->get('security.authorization_checker')->isGranted("ROLE_USER")) {
            $menu->addChild('User', array('route' => ''))
                ->setAttribute('icon', 'fa fa-money');
        }

        return $menu;
    }
}