<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BooksRepository;
use App\Entity\Books;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig');
    }

    #[Route('/library/addbook', name: 'app_library_books')]
    public function addBook(): Response
    {
        return $this->render('library/add_book.html.twig');
    }

    #[Route('/library/addbook_init', name: 'app_library_books_add', methods: ['POST'])]
    public function addBookInit(Request $request, ManagerRegistry $manager): Response
    {
        $book = new Books();
        $data = $request->request->all();
        $book->addBook($data);

        $entityManager = $manager->getManager();
        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('app_library_show_books');
    }
    #[Route('/library/showbooks', name: 'app_library_show_books')]
    public function showBooks(BooksRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        return $this->render('library/all_books.html.twig', ['books' => $books]);
    }

    #[Route('/library/showsbook/{name}', name: 'app_library_single_book')]
    public function showSingleBook(string $name, BooksRepository $bookRepository): Response
    {
        $book = $bookRepository->findOneBy(['name' => $name]);
        return $this->render('library/single_book.html.twig', ['book' => $book]);
    }

    #[Route('/library/deletebook/{isbn}', name: 'app_library_delete_book')]
    public function deleteBook(int $isbn, BooksRepository $bookRepository, ManagerRegistry $manager): Response
    {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);
        $entityManager = $manager->getManager();

        if ($book === null) {
            return $this->redirectToRoute('app_library_show_books');
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('app_library_show_books');
    }

    #[Route('/library/editbook/{isbn}', name: 'app_library_edit_book')]
    public function editBook(int $isbn, BooksRepository $bookRepository): Response
    {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);
        return $this->render('library/edit_book.html.twig', ['book' => $book]);
    }

    #[Route('/library/editbook_init/{isbn}', name: 'app_library_edit_book_init', methods: ['POST'])]
    public function editBookInit(int $isbn, Request $request, BooksRepository $bookRepository, ManagerRegistry $manager): Response
    {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);
        $data = $request->request->all();
        $bookRepository->updateBook($data);

        $entityManager = $manager->getManager();

        if ($book === null) {
            return $this->redirectToRoute('app_library_show_books');
        }

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('app_library_show_books');
    }
}
