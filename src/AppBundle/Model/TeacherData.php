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
    private $rest_ideal;
    private $rest_ideal_cycle;
    private $rest_ideal_reduc;

    public function __construct(User $teacher,$pi,$fct,$reduccion,$rest_ideal,$rest_ideal_cycle,$rest_ideal_reduc)
    {
        $this->teacher = $teacher;
        $this->fct = $fct;
        $this->pi = $pi;
        $this->reduction = $reduccion;
        $this->rest_ideal = $rest_ideal;
        $this->rest_ideal_cycle = $rest_ideal_cycle;
        $this->rest_ideal_reduc = $rest_ideal_reduc;
    }

    /**
     * @return mixed
     */
    public function getRestIdeal()
    {
        return $this->rest_ideal;
    }

    /**
     * @param mixed $rest_ideal
     */
    public function setRestIdeal($rest_ideal)
    {
        $this->rest_ideal = $rest_ideal;
    }

    /**
     * @return mixed
     */
    public function getRestIdealCycle()
    {
        return $this->rest_ideal_cycle;
    }

    /**
     * @param mixed $rest_ideal_cycle
     */
    public function setRestIdealCycle($rest_ideal_cycle)
    {
        $this->rest_ideal_cycle = $rest_ideal_cycle;
    }

    /**
     * @return mixed
     */
    public function getRestIdealReduc()
    {
        return $this->rest_ideal_reduc;
    }

    /**
     * @param mixed $rest_ideal_reduc
     */
    public function setRestIdealReduc($rest_ideal_reduc)
    {
        $this->rest_ideal_reduc = $rest_ideal_reduc;
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