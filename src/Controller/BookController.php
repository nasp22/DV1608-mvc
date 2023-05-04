<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BookController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'Biblioteket',
        ]);
    }

    #[Route('/library/createPost', name: 'book_create_post', methods: ['POST'])]
    public function createBookPost(
        ManagerRegistry $doctrine,
        Request $request,
        SessionInterface $session
    ): Response {

        $newBook = [
        'title' => $request->request->get('title'),
        'author' => $request->request->get('author'),
        'isbn' => $request->request->get('isbn'),
        'img' => $request->request->get('img')
        ];

        $session->set("newBook", $newBook );

        return $this->redirectToRoute('book_create_get');
    }

    #[Route('/library/create', name: 'book_create_get')]
    public function createBook(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {

        $newBook = $session->get("newBook");

        $entityManager = $doctrine->getManager();
        $book = new Book();
        $book->setTitle($newBook['title']);
        $book->setAuthor($newBook['author']);
        $book->setIsbn($newBook['isbn']);
        $book->setImg($newBook['img']);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $session->set("newBook", "");

        return $this->render('library/created.html.twig', [
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'isbn' => $book->getIsbn(),
            'img' => $book->getImg(),
        ]);
    }

    #[Route('/library/show', name: 'book_show_all')]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $library = [];

        foreach ($books as $book) {
            $book= [
            'title' => $book->getTitle(),
            'author'=> $book->getAuthor(),
            'isbn' => $book->getIsbn(),
            'img' => $book->getImg()
            ];

            $library[] = $book;
        };

        $data = [
            'books' => $library
        ];

        return $this->render('library/showAll.html.twig', $data);
    }

    #[Route('/library/show/{id}', name: 'book_by_id')]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        return $this->json($book);
    }

    #[Route('/library/delete/{id}', name: 'book_delete_by_id')]
    public function deleteBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $bookRepository->remove($book, true);

        return $this->redirectToRoute('book_show_all');
    }

    #[Route('/library/update/{oldValue<\d+>}/{newValue<\d+>}', name: 'book_update')]
    public function updateBook(
        BookRepository $bookRepository,
        string $oldValue,
        string $newValue
    ): Response {
        $book = $bookRepository->find($oldValue);

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id '.$oldValue
            );
        }

        // $book->setValue($value);
        $bookRepository->save($book, true);

        return $this->redirectToRoute('book_show_all');
    }
}
