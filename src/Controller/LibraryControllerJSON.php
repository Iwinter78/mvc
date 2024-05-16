<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use App\Repository\BooksRepository;
use App\Entity\Books;

class LibraryControllerJSON extends AbstractController
{
    #[Route('api/library/books', name: 'api_library')]
    public function index(BooksRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $booksArray = [];

        foreach ($books as $book) {
            $booksArray[] = [
                'id' => $book->getId(),
                'name' => $book->getName(),
                'isbn' => $book->getIsbn(),
                'author' => $book->getAuthor(),
                'image' => $book->getImage(),
            ];
        }

        return new JsonResponse($booksArray);
    }

    #[Route('api/library/book/{isbn}', name: 'api_library_single_book')]
    public function showSingleBook(int $isbn, BooksRepository $bookRepository): Response
    {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            return new JsonResponse(['error' => 'Boken finns inte!'], Response::HTTP_NOT_FOUND);
        }

        $bookArray = [
            'id' => $book->getId(),
            'name' => $book->getName(),
            'isbn' => $book->getIsbn(),
            'author' => $book->getAuthor(),
            'image' => $book->getImage(),
        ];

        return new JsonResponse($bookArray);
    }
}
