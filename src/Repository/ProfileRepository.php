<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Profile>
 *
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    public function save(Profile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Profile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findProfileById(int $id): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.profileBooks', 'pb')->addSelect('pb')
            ->leftJoin('pb.book', 'b')->addSelect('b')
            ->leftJoin('p.profileInterests', 'pi')->addSelect('pi')
            ->leftJoin('pi.interest', 'i')->addSelect('i')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult();
    }

    public function findAllActive(): array
    {
        $activeStatus = 1;
        return $this->createQueryBuilder('p')
            ->select('p', 'pb', 'b', 'pi', 'i')
            ->leftJoin('p.profileBooks', 'pb')
            ->leftJoin('pb.book', 'b')
            ->leftJoin('p.profileInterests', 'pi')
            ->leftJoin('pi.interest', 'i')
            ->andWhere('p.status = :val')
            ->setParameter('val', $activeStatus)
            ->getQuery()
            ->getArrayResult();
    }
}
