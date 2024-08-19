<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/', name: 'article')]
    public function index(EntityManagerInterface $em): Response

    {
        $repository = $em->getRepository(Article::class);
        $articles = $repository->findAll();

        // dd($articles);
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('article/{id}', name: 'article_show')]
    public function show(EntityManagerInterface $em, $id)
    {
        $repository = $em->getRepository(Article::class);

        $artic = $repository->find($id);
        if (!$artic) {
            throw $this->createNotFoundException("l'article n'existe pas " . $id);
        }

        return $this->render('article/index.html.twig', [
            'article' => $artic,
        ]);
    }
}
