<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Library;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\LibraryRepository;


class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    #[Route('/book/create', name: 'book_create', methods: ['GET', 'POST'])]
    public function createBook(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if ($request->isMethod('POST')) {
            $title = $request->request->get('title');
            $isbn = $request->request->get('isbn');
            $author = $request->request->get('author');

            $book = new Library();
            $book->setTitle($title);
            $book->setISBN($isbn);
            $book->setAuthor($author);

        $image = $request->files->get('image');
        if ($image instanceof UploadedFile) {
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '.' . $image->guessExtension();

            try {
                $image->move(
                    $this->getParameter('upload_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle the exception if necessary
            }

            $book->setImage($newFilename);
        }
            // Handle image upload if applicable

            $entityManager->persist($book);
            $entityManager->flush();

            // Redirect to book details page or display success message
            return $this->redirectToRoute('book_show', ['id' => $book->getId()]);
        }

        // Render the book creation form
        return $this->render('create.html.twig');
    }

    #[Route('/book/show/all', name: 'book_show_all', methods: ['GET'])]
    public function showAllBooks(LibraryRepository $libraryRepository): Response
    {
        $books = $libraryRepository->findAll();

        // Render the book list page
        return $this->render('show_all.html.twig', ['books' => $books]);
    }

    #[Route('/book/show/{id}', name: 'book_show', methods: ['GET'])]
    public function showBook(Library $book): Response
    {
        // Render the book details page
        return $this->render('show.html.twig', ['book' => $book]);
    }


    #[Route('/book/delete/{id}', name: 'book_delete')]
    public function deleteBookById(
        LibraryRepository $libraryRepository,
        EntityManagerInterface $entityManager,
        int $id
    ): Response {
        $book = $libraryRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException('No book found for id '.$id);
        }

        $entityManager->remove($book);
        $entityManager->flush();

        // You can add a success message if needed

        return $this->redirectToRoute('book_show_all');
    }
}
