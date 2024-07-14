<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/{id}', name: 'app_comment')]
    public function index(EntityManagerInterface $entityManager, int $id): Response
    {

        $comment =  $entityManager->getRepository(Comment::class)->find($id);

        return $this->render('home/index.html.twig', [
            'comment' => $comment,
        ]);
    }
}  
