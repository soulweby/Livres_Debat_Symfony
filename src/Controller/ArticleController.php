<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article')]
    public function index(EntityManagerInterface $em): Response

    {
        $repository = $em->getRepository(Article::class);
        $articles = $repository->findAll();

        // dd($articles);
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
