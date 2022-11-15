<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\CommentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends AbstractController
{
    public function add(Request $request, ManagerRegistry $doctrine){

        $comment = new Comment();


        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();


        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $comment->setIdUser($user);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setIdArticle();


            $comment = $form->getData();



            $entitymanager = $doctrine->getManager();
            $entitymanager->persist($comment);
            $entitymanager->flush();



            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('comment/add.html.twig', [
            'form' => $form,
        ]);
    }
}