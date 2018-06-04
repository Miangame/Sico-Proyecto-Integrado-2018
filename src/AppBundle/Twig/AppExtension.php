<?php

namespace AppBundle\Twig;

/**
 * Usada para añadir funciones a twig
 * @package AppBundle\Twig
 */
class AppExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('valclass', array($this, 'getClass')),
        );
    }

    /**
     * Saber dependiendo del valor, que tipo de clase CSS le corresponde
     * @param $value
     * @return string
     */
    public function getClass($value)
    {
        if ($value < -0.5)
            return "warning_state";
        else if ($value >= -0.5 AND $value <= 0.5)
            return "ok_state";
        else
            return "warning_up_state";

    }
}