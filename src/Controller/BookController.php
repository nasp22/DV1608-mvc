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

    #[Route('/library/create', name: 'book_create_post', methods: ['POST'])]
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

        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setTitle($newBook['title']);
        $book->setAuthor($newBook['author']);
        $book->setIsbn($newBook['isbn']);
        $book->setImg($newBook['img']);

        $entityManager->persist($book);

        $entityManager->flush();

        $session->set("newBook", $book);

        return $this->redirectToRoute('book_create_get');
    }

    #[Route('/library/create', name: 'book_create_get')]
    public function createBook(
        SessionInterface $session
    ): Response {

        $session->set("newBook", "");

        $this->addFlash(
            "success",
            "Boken finns nu i biblioteket!"
        );
        return $this->redirectToRoute('book_show_all');
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
            'img' => $book->getImg(),
            'id' => $book->getId()
            ];

            $library[] = $book;
        };

        $data = [
            'books' => $library
        ];

        return $this->render('library/showAll.html.twig', $data);
    }

    #[Route('/library/deleted', name: 'book_delete_yes', methods: ['POST'])]
    public function deleteBookById(
        BookRepository $bookRepository,
        Request $request,
    ): Response {

        $id = $request->request->get('id');
        $id = (int)$id;
        $book = $bookRepository->find($id);

        if (!$book) {
            $this->addFlash(
                "warning",
                "Boken finns inte i biblioteket!"
            );

            return $this->redirectToRoute('book_show_all');
        }

        $bookRepository->remove($book, true);

        $this->addFlash(
            "success",
            "Boken är nu raderad!"
        );

        return $this->redirectToRoute('book_show_all');
    }

    #[Route('/library/show/{id}', name: 'book_show_one')]
    public function showBookById(
        BookRepository $bookRepository,
        int $id,
        Request $request
    ): Response {
        $book = $bookRepository->find($id);

        $book= [
            'title' => $book->getTitle(),
            'author'=> $book->getAuthor(),
            'isbn' => $book->getIsbn(),
            'img' => $book->getImg(),
            'id' => $book->getId()
            ];

            return $this->render('library/show.html.twig', $book);
    }

    #[Route('/library/update', name: 'book_update', methods: ['POST'])]
    public function updateBook(
        BookRepository $bookRepository,
        Request $request,
        SessionInterface $session
    ): Response {
        $data = [
            'title' => $request->request->get('title'),
            'author' => $request->request->get('author'),
            'isbn' => $request->request->get('isbn'),
            'img' => $request->request->get('img'),
            'id' => $request->request->get('id'),
        ];
        $session->set("book", $data);

        return $this->redirectToRoute('book_update_get');
    }

    #[Route('/library/delete', name: 'book_delete', methods: ['POST'])]
    public function deleteBook(
        BookRepository $bookRepository,
        Request $request,
        SessionInterface $session
    ): Response {
        $data = [
            'title' => $request->request->get('title'),
            'author' => $request->request->get('author'),
            'isbn' => $request->request->get('isbn'),
            'img' => $request->request->get('img'),
            'id' => $request->request->get('id'),
        ];
        $session->set("book", $data);

        return $this->redirectToRoute('book_delete_get');
    }

    #[Route('/library/update', name: 'book_update_get')]
    public function updateBookGet(
        BookRepository $bookRepository,
        SessionInterface $session,
        Request $request,
    ): Response {
        $data = $session->get("book");
        $session->set("book", "");
        return $this->render('library/update-form.html.twig', $data);
    }


    #[Route('/library/delete', name: 'book_delete_get')]
    public function deleteBookGet(
        BookRepository $bookRepository,
        SessionInterface $session,
        Request $request,
    ): Response {
        $data = $session->get("book");
        $session->set("book", "");
        return $this->render('library/delete-form.html.twig', $data);
    }

    #[Route('/library/updated', name: 'book_update_form', methods: ['POST'])]
    public function updateBookForm(
        BookRepository $bookRepository,
        Request $request,
    ): Response {

        $id = $request->request->get('id');
        $id = (int)$id;
        $book = $bookRepository->find($id);

        if (!$book) {
            $this->addFlash(
                "warning",
                "Boken kunde inte hittas!"
            );
            return $this->redirectToRoute('book_show');
        }

        $book->setTitle($request->request->get('title'));
        $book->setAuthor($request->request->get('author'));
        $book->setIsbn($request->request->get('isbn'));
        $book->setImg($request->request->get('img'));

        $bookRepository->save($book, true);

        $this->addFlash(
            "success",
            "Boken är nu uppdaterad!"
        );

        return $this->redirectToRoute('book_show_all');
    }
}
