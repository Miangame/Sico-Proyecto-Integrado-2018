<?php

namespace AppBundle\Repository;

/**
 * StudentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StudentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllStudents($convocatory = null)
    {
        return $this->findAll();
    }

    public function getAllStudentsConvocatory($convocatory)
    {
        return $this->findBy(Array("convocatory" => $convocatory));
    }

    public function getAllStudentsNoDistribution($convocatory, $type)
    {
        $table = "";
        if ($type == 'company')
            $table = 'AppBundle:Distribution_company';
        else
            $table = 'AppBundle:Distribution_project';

        $q2b = $this->getEntityManager()->createQueryBuilder()
            ->select('st.id')
            ->from($table, 'd')
            ->join('d.student', 'st');

        $arrayIds = $this->arrayIdsToString($q2b->getQuery()->getArrayResult());

        if (count($arrayIds) > 0)
            return $this->getStudentsNotIN($convocatory, $arrayIds);
        return $this->getAllStudentsConvocatory($convocatory);
    }

    public function getStudentsNotIN($convocatory, $arrayIds)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('AppBundle:Student', 't')
            ->where('t.convocatory = :convocatory_id')
            ->andWhere('t.id NOT IN(' . implode(",", $arrayIds) . ')')
            ->setParameter('convocatory_id', $convocatory);


        return $qb->getQuery()->getResult();
    }


    private function arrayIdsToString($array)
    {
        $arrayIds = Array();

        foreach ($array as $id) {
            $arrayIds[] = $id["id"];
        }

        return $arrayIds;
    }

    public function getAllStudentsWithGroup()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t, u.name, w.convocatory, x.course')
            ->from('AppBundle:Student', 't')
            ->join('t.group', 'u')
            ->join('t.convocatory', 'w')
            ->join('w.schoolYear', 'x');

        return $qb->getQuery()->getArrayResult();
    }

    public function getStudentsBySchoolYearConvocatory($schoolYear, $convocatory)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t, CONCAT(cc.course, cy.initials, \'-\', u.gr) name, cy.initials cycle, w.convocatory, x.course')
            ->from('AppBundle:Student', 't')
            ->join('t.group', 'u')
            ->join('u.course_cycle', 'cc')
            ->join('cc.cycle', 'cy')
            ->join('t.convocatory', 'w')
            ->join('w.schoolYear', 'x')
            ->where('x.id = :sc_id')
            ->andWhere('w.id = :convocatory_id')
            ->setParameter('sc_id', $schoolYear)
            ->setParameter('convocatory_id', $convocatory);

        return $qb->getQuery()->getArrayResult();
    }
}
