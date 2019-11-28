<?php

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends ServiceEntityRepository implements PhotoRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    public function getList(int $page = 1, int $limit = 10)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from('App\Entity\Photo', 'p')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        $paginator = new Paginator($query, false);

        return $paginator;
    }

}
