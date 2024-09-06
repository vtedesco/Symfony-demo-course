<?php

namespace App\Controller\Front;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\DeleteCommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/delete/{id}', name: 'app_front_comment_delete')]
    public function index(
        EntityManagerInterface $entityManager,
        Request $request,
        int $id
    ): Response
    {
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        if(!$comment){
            throw $this->createNotFoundException('Comment not found');
        }

        $form = $this->createForm(DeleteCommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();

            $entityManager->remove($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_front_news_show',['id'=>$comment->getNews()->getId()]);
        }

        return $this->render('front/comment/index.html.twig', [
            'controller_name' => 'CommentController',
            'comment' => $comment,
            'form' => $form,
        ]);
    }
}
