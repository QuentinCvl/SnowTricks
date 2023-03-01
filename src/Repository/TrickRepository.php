<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<Trick>
 *
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function add(Trick $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(Trick $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

  /**
   * @param $page
   * @param $maxPerPage
   * @return Paginator
   */
    public function getTrickPaginator($page, $maxPerPage): Paginator
    {
      if (!is_numeric($page)) {
        throw new InvalidArgumentException(
          'La valeur de l\'argument $page est incorrecte (valeur : ' . $page . ').'
        );
      }

      if ($page < 1) {
        throw new NotFoundHttpException('La page demandée n\'existe pas');
      }

      if (!is_numeric($maxPerPage)) {
        throw new InvalidArgumentException(
          'La valeur de l\'argument $maxPerPage est incorrecte (valeur : ' . $maxPerPage . ').'
        );
      }

      $qb = $this->createQueryBuilder('a')
        ->where('CURRENT_DATE() >= a.createdAt')
        ->orderBy('a.createdAt', 'DESC');

      $query = $qb->getQuery();

      $firstResult = ($page - 1) * $maxPerPage;
      $query->setFirstResult($firstResult)->setMaxResults($maxPerPage);
      $paginator = new Paginator($query);

      if (($paginator->count() <= $firstResult) && $page != 1) {
        throw new NotFoundHttpException('La page demandée n\'existe pas.');
      }

      return $paginator;
    }
    // /**
    //  * @return Trick[] Returns an array of Trick objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trick
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
