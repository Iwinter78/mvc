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
        print_r($data);
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
}
