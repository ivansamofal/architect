<?php

namespace App\Repository;

use App\Entity\ProfileProgrammingLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProfileProgrammingLanguage>
 *
 * @method ProfileProgrammingLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfileProgrammingLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfileProgrammingLanguage[]    findAll()
 * @method ProfileProgrammingLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileProgrammingLanguageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfileProgrammingLanguage::class);
    }

    public function save(ProfileProgrammingLanguage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProfileProgrammingLanguage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return ProfileProgrammingLanguage[] Returns an array of ProfileProgrammingLanguage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ProfileProgrammingLanguage
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
