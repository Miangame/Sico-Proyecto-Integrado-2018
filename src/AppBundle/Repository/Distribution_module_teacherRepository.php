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
            ->select('t.id, m.initials module, CONCAT(u.first_name, \' \', u.last_name) teacher, CONCAT(cc.course, cy.name) gr, c.course course, t.hours hours, t.desdoble desdoble')
            ->from('AppBundle:Distribution_module_teacher', 't')
            ->join('t.module', 'm')
            ->join('t.teacher', 'u')
            ->join('t.schoolYear', 'c')
            ->join('m.course_cycle', 'cc')
            ->join('cc.cycle', 'cy');

        return $qb->getQuery()->getArrayResult();
    }

    public function getDistributionsLastYear()
    {
        /** @var SchoolYearRepository $syRepo */
        $syRepo = $this->_em->getRepository('AppBundle:SchoolYear');
        $lastSchoolYear = $syRepo->getLastCourse();

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t.id, m.initials module, CONCAT(u.first_name, \' \', u.last_name) teacher, CONCAT(cc.course, cy.name) gr, c.course course, t.hours hours, t.desdoble desdoble')
            ->from('AppBundle:Distribution_module_teacher', 't')
            ->join('t.module', 'm')
            ->join('t.teacher', 'u')
            ->join('m.course_cycle', 'cc')
            ->join('t.schoolYear', 'c')
            ->join('cc.cycle', 'cy')
            ->where('t.schoolYear = :schoolYear_id')
            ->setParameter('schoolYear_id', $lastSchoolYear);

        return $qb->getQuery()->getArrayResult();
    }

    public function getDistribution($course)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('t.id, m.initials module, CONCAT(u.first_name, \' \', u.last_name) teacher, CONCAT(cc.course, cy.name) gr, c.course course, t.hours hours, t.desdoble desdoble')
            ->from('AppBundle:Distribution_module_teacher', 't')
            ->join('t.module', 'm')
            ->join('t.teacher', 'u')
            ->join('m.course_cycle', 'cc')
            ->join('t.schoolYear', 'c')
            ->join('cc.cycle', 'cy')
            ->where('c.course=:course')
            ->setParameter('course', $course);

        return $qb->getQuery()->getArrayResult();
    }

    public function getHoursByUserId($userId, $schoolYear)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('SUM(dmt.hours)')
            ->from('AppBundle:Distribution_module_teacher', 'dmt')
            ->where('dmt.teacher=:id_user')
            ->andWhere('dmt.schoolYear=:schoolYear')
            ->setParameter('schoolYear', $schoolYear)
            ->setParameter('id_user', $userId);

        $result = $qb->getQuery()->getArrayResult()[0][1];
        return ($result ? $result : 0);
    }

    public function getHours2ByUserId($userId, $schoolYear)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('SUM(dmt.hours)')
            ->from('AppBundle:Distribution_module_teacher', 'dmt')
            ->join('dmt.module', 'm')
            ->join('m.course_cycle', 'cc')
            ->where('dmt.teacher = :id_user')
            ->andWhere('dmt.schoolYear=:schoolYear')
            ->andWhere('cc.course = 2')
            ->setParameter('schoolYear', $schoolYear)
            ->setParameter('id_user', $userId);

        $result = $qb->getQuery()->getArrayResult()[0][1];
        return ($result ? $result : 0);
    }

    public function getHours2()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('SUM(dmt.hours)')
            ->from('AppBundle:Distribution_module_teacher', 'dmt')
            ->join('dmt.module', 'm')
            ->join('m.course_cycle', 'cc')
            ->andWhere('cc.course = 2');

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
