<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
/*        $faker = Factory::create('fr_FR');
        $posts=[];
        for ($i = 0 ; $i < 10 ; $i++) {
            $post = new \StdClass();
            $post->title = $faker->sentence();
            $post->content = $faker->text(2000);
            $post->author = $faker->name();
            $post->image = 'https://picsum.photos/seed/post-'.$i.'/750/300';
            $post->createdAt = $faker->dateTimeBetween('-3 years', 'now', 'Europe/Paris');

            array_push($posts, $post);
        }*/

        $articles = $doctrine->getRepository(Article::class)->findAll();

/*        dd($articles);*/

        return $this->render('home/index.html.twig', [
            'posts' => $articles
        ]);
    }
}
