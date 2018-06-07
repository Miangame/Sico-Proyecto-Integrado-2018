<?php

namespace AppBundle\Repository;

/**
 * Distribution_module_teacherRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Distribution_module_teacherRepository extends \Doctrine\ORM\EntityRepository
{
    public function getDistributions()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t.id, m.initials module, CONCAT(u.first_name, \' \', u.last_name) teacher, CONCAT(g.course, cy.name, \'-\'g.gr) gr, c.course course, t.hours hours, t.desdoble desdoble')
            ->from('AppBundle:Distribution_module_teacher', 't')
            ->join('t.module', 'm')
            ->join('t.teacher', 'u')
            ->join('t.group', 'g')
            ->join('t.schoolYear', 'c')
            ->join('g.cycle', 'cy');

        return $qb->getQuery()->getArrayResult();
    }

    public function getDistributionsLastYear()
    {
        /** @var SchoolYearRepository $syRepo */
        $syRepo = $this->_em->getRepository('AppBundle:SchoolYear');
        $lastSchoolYear = $syRepo->getLastCourse();

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t.id, m.initials module, CONCAT(u.first_name, \' \', u.last_name) teacher, CONCAT(g.course, cy.name,\'-\', g.gr) gr, c.course course, t.hours hours, t.desdoble desdoble')
            ->from('AppBundle:Distribution_module_teacher', 't')
            ->join('t.module', 'm')
            ->join('t.teacher', 'u')
            ->join('t.group', 'g')
            ->join('t.schoolYear', 'c')
            ->join('g.cycle', 'cy')
            ->where('t.schoolYear = :schoolYear_id')
            ->setParameter('schoolYear_id', $lastSchoolYear);

        return $qb->getQuery()->getArrayResult();
    }

    public function getDistribution($course)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t.id, m.initials module, CONCAT(u.first_name, \' \', u.last_name) teacher, CONCAT(g.course, cy.name, \'-\',g.gr) gr, c.course course, t.hours hours, t.desdoble desdoble')
            ->from('AppBundle:Distribution_module_teacher', 't')
            ->join('t.module', 'm')
            ->join('t.teacher', 'u')
            ->join('t.group', 'g')
            ->join('t.schoolYear', 'c')
            ->join('g.cycle', 'cy')
            ->where('c.course=:course')
            ->setParameter('course', $course);

        return $qb->getQuery()->getArrayResult();
    }

    public function getHoursByUserId($userId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('SUM(dmt.hours)')
            ->from('AppBundle:Distribution_module_teacher', 'dmt')
            ->where('dmt.teacher=:id_user')
            ->setParameter('id_user', $userId);

        $result = $qb->getQuery()->getArrayResult()[0][1];
        return ($result ? $result : 0);
    }

    public function getHours2ByUserId($userId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('SUM(dmt.hours)')
            ->from('AppBundle:Distribution_module_teacher', 'dmt')
            ->join('dmt.group','sg')
            ->where('dmt.teacher = :id_user')
            ->andWhere('sg.course = 2')
            ->setParameter('id_user', $userId);

        $result = $qb->getQuery()->getArrayResult()[0][1];
        return ($result ? $result : 0);
    }

    public function getHours2()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('SUM(dmt.hours)')
            ->from('AppBundle:Distribution_module_teacher', 'dmt')
            ->join('dmt.group','sg')
            ->where('sg.course = 2');

        $result = $qb->getQuery()->getArrayResult()[0][1];
        return ($result ? $result : 0);
    }

    public function getHours()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('SUM(dmt.hours)')
            ->from('AppBundle:Distribution_module_teacher', 'dmt');

        $result = $qb->getQuery()->getArrayResult()[0][1];
        return ($result ? $result : 0);
    }
}
