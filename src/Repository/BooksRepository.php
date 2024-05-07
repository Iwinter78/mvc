<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Books>
 *
 * @method Books|null find($id, $lockMode = null, $lockVersion = null)
 * @method Books|null findOneBy(array $criteria, array $orderBy = null)
 * @method Books[]    findAll()
 * @method Books[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }

    //    /**
    //     * @return Books[] Returns an array of Books objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Books
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    public function updateBook(array $data): void
    {   
        $connection = $this->getEntityManager()->getConnection();
    
        $sqlFindId = "SELECT id FROM books WHERE isbn = :isbn OR name = :name OR author = :author";
        $stmt = $connection->executeQuery($sqlFindId, [
            'isbn' => $data['isbn'],
            'name' => $data['name'],
            'author' => $data['author']
        ]);
        $book = $stmt->fetch();
    
        $bookId = $book['id'];

        $sqlUpdate = "
        UPDATE books SET name = :name,
        isbn = :isbn, author = :author,
        image = :image WHERE id = :id
        ";
        $connection->executeUpdate($sqlUpdate, [
            'name' => $data['name'],
            'isbn' => $data['isbn'],
            'author' => $data['author'],
            'image' => $data['image'],
            'id' => $bookId
        ]);        
    }
}
