<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCriteria($isActive, $isMember, $lastLoginAtFrom, $lastLoginAtTo, $userTypes)
    {
        $qb = $this->createQueryBuilder('u');

        if ($isActive !== null) {
            $qb->andWhere('u.isActive = :isActive')
                ->setParameter('isActive', $isActive);
        }

        if ($isMember !== null) {
            $qb->andWhere('u.isMember = :isMember')
                ->setParameter('isMember', $isMember);
        }

        if ($lastLoginAtFrom !== null && $lastLoginAtTo !== null) {
            $qb->andWhere('u.lastLoginAt BETWEEN :lastLoginAtFrom AND :lastLoginAtTo')
                ->setParameter('lastLoginAtFrom', $lastLoginAtFrom)
                ->setParameter('lastLoginAtTo', $lastLoginAtTo);
        }

        if (!empty($userTypes)) {
            $qb->andWhere('u.userType IN (:userTypes)')
                ->setParameter('userTypes', $userTypes);
        }

        return $qb->getQuery()->getArrayResult();
    }

}
