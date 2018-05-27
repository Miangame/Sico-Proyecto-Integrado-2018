<?php

namespace AppBundle\Model;

use AppBundle\Entity\User;

/**
 * Enunciado:
 * @author: Javier Ponferrada López
 * fecha: 27/5/18
 */

class TeacherData
{
    private $teacher;
    private $pi;
    private $fct;
    private $reduction;

    public function __construct(User $teacher,$pi,$fct,$reduccion)
    {
        $this->teacher = $teacher;
        $this->fct = $fct;
        $this->pi = $pi;
        $this->reduction = $reduccion;
    }

    /**
     * @param mixed $reduction
     */
    private function setReduction($reduction)
    {
        $this->reduction = $reduction;
    }

    /**
     * @return mixed
     */
    public function getReduction()
    {
        return $this->reduction;
    }

    /**
     * @return User
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param User $teacher
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
    }

    /**
     * @return mixed
     */
    public function getPi()
    {
        return $this->pi;
    }

    /**
     * @param mixed $pi
     */
    public function setPi($pi)
    {
        $this->pi = $pi;
    }

    /**
     * @return mixed
     */
    public function getFct()
    {
        return $this->fct;
    }

    /**
     * @param mixed $fct
     */
    public function setFct($fct)
    {
        $this->fct = $fct;
    }
}