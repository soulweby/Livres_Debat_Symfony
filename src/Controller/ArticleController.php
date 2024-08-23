<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('article/{slug}', name: 'article_show')]
    public function show(string $slug, Request $request,  EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        $artic = $repository->findOneBy(['slug' => $slug]);
        
        if (!$artic) {
            throw $this->createNotFoundException("l'article n'existe pas " . ['slug' => $slug]);
        }
        $commentaire = new Comment();
        $form = $this->createForm(CommentType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setArticle($artic);
            // $commentaire->setCreatedAt(new \DateTime());
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('article_show', ['slug' => $artic->getSlug()]);
        }

        return $this->render('article/index.html.twig', [
            'article' => $artic,
            'comment_form' => $form->createView(),
        ]);
    }
}
