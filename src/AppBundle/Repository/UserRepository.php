<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\User;

class UserRepository extends EntityRepository
{
    public function getUsers()
    {
        $users = $this->findAll();
        $user_teacher = Array();
        /** @var User $user */
        foreach ($users as $user){
            if ($user->hasRole("ROLE_TEACHER"))
                $user_teacher[] = $user;
        }

        return $user_teacher;
    }

    public function getUsersValid(){
        $users = $this->findBy(Array("to_distribute"=>"1"));

        $user_teacher = Array();
        /** @var User $user */
        foreach ($users as $user){
            if ($user->hasRole("ROLE_TEACHER"))
                $user_teacher[] = $user;
        }

        return $user_teacher;
    }

    public function getHoursModules($yearId,$userId){
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('SUM(md.hours)')
            ->from('AppBundle:Distribution_module_teacher', 'dt')
            ->join('dt.module', 'md')
            ->where('dt.teacher = :user_id')
            ->andWhere('md.course = 2')
            ->andWhere('dt.schoolYear = :year_id')
            ->setParameter('year_id',$yearId)
            ->setParameter('user_id',$userId);

        return $qb->getQuery()->getResult()[0][1];
    }

    public function getFCTDistribution($convocatory,$userId){
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('dc.id')
            ->from('AppBundle:Distribution_company', 'dc')
            ->join('dc.student', 'st')
            ->where('dc.user = :user_id')
            ->groupBy('dc.company')
            ->andWhere('st.convocatory = :convocatory_id')
            ->setParameter('user_id',$userId)
            ->setParameter('convocatory_id',$convocatory);

        return count($qb->getQuery()->getResult());
    }

    public function getPIDistribution($convocatory,$userId){
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('dp.id')
            ->from('AppBundle:Distribution_project', 'dp')
            ->join('dp.student', 'st')
            ->where('dp.user = :user_id')
            ->groupBy('dp.project')
            ->andWhere('st.convocatory = :convocatory_id')
            ->setParameter('user_id',$userId)
            ->setParameter('convocatory_id',$convocatory);

        return count($qb->getQuery()->getResult());
    }
}
