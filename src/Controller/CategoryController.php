<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/addCat', name: 'app_cat')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $category = $form->getData();

            $entitymanager = $doctrine->getManager();
            $entitymanager->persist($category);
            $entitymanager->flush();

            return $this->redirectToRoute('app_home');

        }

        return $this->renderForm('category/addCat.html.twig', [
            'form' => $form,
        ]);
    }

}