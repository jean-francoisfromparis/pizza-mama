<?php

namespace App\Controller;

use App\Entity\Reply;
use DateTimeImmutable;
use App\Form\ReplyType;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Form\Comments1Type;
use App\Form\CommentsReplyType;
use Symfony\Component\Mime\Address;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/comments")
 */
class CommentsController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN", statusCode=404, message="Pour accéder à cette page vous devez être connecté en tant qu'administrateur")
     * @Route("/", name="comments_index", methods={"GET"})
     */
    public function index(CommentsRepository $commentsRepository): Response
    {
        return $this->render('comments/index.html.twig', [
            'comments' => $commentsRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", statusCode=404, message="Pour accéder à cette page vous devez être connecté en tant qu'administrateur")
     * @Route("/new", name="comments_new", methods={"GET","POST"}) //TODOs a supprimer
     */
    public function new(Request $request): Response
    {
        $comment = new Comments();
        $form = $this->createForm(Comments1Type::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comments/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", statusCode=404, message="Pour accéder à cette page vous devez être connecté en tant qu'administrateur")
     * @Route("/{id}", methods={"GET"})
     * @Template
     */
    public function show(
        Request $request,
        Comments $comment,
        MailerInterface $mailer,
        EntityManagerInterface $em
    ) {

        $form = $this->createForm(ReplyType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $text = $form->get('reply')->getData();

            $comment->setReply($text);

            $em->flush();

            $email = (new TemplatedEmail())
                ->from('pizze.mama.it@gmail.com')
                ->to(new Address($comment->getEmail()))
                ->subject('Merci pour commentaire')

                // path of the Twig template to render
                ->htmlTemplate('comments/email/email.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'comment' => $comment,
                ]);
            $mailer->send($email);
            return $this->redirectToRoute('comments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comments/show.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", statusCode=404, message="Pour accéder à cette page vous devez être connecté en tant qu'administrateur")
     * @Route("/{id}/edit", name="comments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comments $comment): Response
    {
        $form = $this->createForm(Comments1Type::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", statusCode=404, message="Pour accéder à cette page vous devez être connecté en tant qu'administrateur")
     * @Route("/{id}", name="comments_delete", methods={"POST"}) //TODOs mettre en role super_admin
     */
    public function delete(Request $request, Comments $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comments_index', [], Response::HTTP_SEE_OTHER);
    }
}
