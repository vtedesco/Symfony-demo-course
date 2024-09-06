<?php

namespace App\Controller\Front;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\News;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsController extends AbstractController
{
    #[Route('/news/{id}', name: 'app_front_news')]
    public function index(
        EntityManagerInterface $entityManager,
        PaginatorInterface $paginator,
        Request $request,
        int $id
    ): Response
    {
        $category = $entityManager->getRepository(Category::class)->find($id);

        if(!$category){
            throw $this->createNotFoundException('Category not found');
        }

        $selectedNews = $paginator->paginate(
            $category->getNews(),
            $request->query->getInt('page', 1), /*page number*/
            10
        );

        return $this->render('front/news/index.html.twig', [
            'controller_name' => 'NewsController',
            'category' => $category,
            'selectedNews' => $selectedNews
        ]);
    }

    #[Route('/news/show/{id}', name: 'app_front_news_show')]
    public function show(
        EntityManagerInterface $entityManager,
        Request $request,
        int $id
    ): Response
    {
        $news = $entityManager->getRepository(News::class)->find($id);

        if(!$news){
            throw $this->createNotFoundException('News not found');
        }

        // Add viewcount for top 10 stats
        $news->addViews();
        $entityManager->persist($news);
        $entityManager->flush();

        // Comment form
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setNews($news);

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_front_news_show',['id'=>$id]);
        }

        return $this->render('front/news/show.html.twig', [
            'controller_name' => 'NewsController',
            'news' => $news,
            'form' => $form,
        ]);
    }
}
