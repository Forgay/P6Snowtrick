<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class TrickController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * HomeController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home", methods="GET")
     */
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="trick_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($trick);
            $this->entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/show/{id}", name="trick_show", methods="GET|POST")
     */
    public function show(Trick $trick, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($comment);

            $comment->setUser($this->getUser());
            $comment->setTrick($trick);


            $this->entityManager->flush();

            $this->addFlash('success', 'Votre commentaire est ajouté !');

            return $this->redirectToRoute('trick_show', [
                'id' => $trick->getId()
            ]);

        }
        return $this->render('trick/show.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * @Route("trick/edit/{id}", name="trick_edit", methods="GET|POST")
     */
    public function edit(Request $request, Trick $trick): Response
    {

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();

            return $this->redirectToRoute('trick_edit', ['id' => $trick->getId()]);
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("delete/{id}", name="trick_delete", methods="DELETE")
     */
    public function delete(Request $request, Trick $trick): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {

            $this->entityManager->remove($trick);
            $this->entityManager->flush();

            $this->addFlash('success', "la figure est supprimée.");

            return $this->redirectToRoute('home');
        }
    }
}
