<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController
{
    #[Route('/addArticle', name: 'app_add_article')]
    public function add(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $article = new Article();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $article->setIdUser($user);
            $article->setCreatedAt(new \DateTimeImmutable());




            $article->setSlug($slugger->slug($article->getTitle()));
            $image= $form->get('image')->getData();
            if($image){
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                // Move the file to the directory where images are stored
                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the image file name
                // instead of its contents
                $article->setImage($newFilename);

            }


            $entitymanager = $doctrine->getManager();
            $entitymanager->persist($article);
            $entitymanager->flush();



            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('article/add.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/article/{slug}', name: 'app_show')]
    public function show(Article $article, Request $request, ManagerRegistry $doctrine) : Response
    {
       /* $commentForm = $this->createForm(CommentType::class);*/

        $comment = new Comment();


        /*$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');*/

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();


        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if($user){
                $comment->setIdUser($user);
                $comment->setCreatedAt(new \DateTimeImmutable());
                $comment->setIdArticle($article);


                $comment = $form->getData();



                $entitymanager = $doctrine->getManager();
                $entitymanager->persist($comment);
                $entitymanager->flush();

                $this->addFlash(
                    'success',
                    'Votre commentaire a été ajouté!'
                );

            }else{

                $this->addFlash(
                    'warning',
                    'Vous devez etre connecté',

                );
            }

            return $this->redirectToRoute('app_show', ['slug' => $article->getSlug()]);
        }

        return $this->renderForm('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $form,
        ]);

    }

    #[Route('/mes-articles', name: 'app_art_user')]
    public function showByUser(ManagerRegistry $doctrine) : Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $articles = $doctrine->getRepository(Article::class)->findBy(['idUser' => $user]);
        /*dd($articles);*/

        return $this->render('profil/article.html.twig', [
            'posts' => $articles
        ]);


    }

    #[Route('/edition/{slug}', name: 'app_edit')]
    public function editArt(Article $article, Request $request,ManagerRegistry $doctrine, SluggerInterface $slugger) : Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

                $article = $form->getData();

                $article->setSlug($slugger->slug($article->getTitle()));

                $entitymanager = $doctrine->getManager();

                $entitymanager->flush();


            return $this->redirectToRoute('app_show', ['slug' => $article->getSlug()]);
        }



        return $this->renderForm('article/edit.html.twig', [
            'posts' => $article,
            'form' => $form
        ]);


    }

    #[Route('/remove/{slug}', name: 'app_remove')]
    public function remove(Article $article, ArticleRepository $artRepo ) : Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $artRepo->remove($article, true);

        return $this->redirectToRoute('app_home');



    }


}
