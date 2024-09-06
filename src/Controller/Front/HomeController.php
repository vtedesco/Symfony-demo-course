<?php

namespace App\Controller\Front;

use App\Entity\Category;
use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_front_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $qb = $entityManager->createQueryBuilder()->select('n')->from('App\Entity\News','n');
        $qb->addOrderBy('n.insertDate', 'DESC');
        $news = $qb->getQuery()->getResult();

        $categories = $entityManager->getRepository(Category::class)->findAll();


        return $this->render('front/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'news' => $news,
            'categories' => $categories,
        ]);
    }


    #[Route('/lipsum', name: 'lipsum')]
    public function lipsum(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();


        foreach (range(1, 10) as $i) {
            $randomCategory = $categories[array_rand($categories,1)];

            $news = new News();
            $news->setInsertDate(new \DateTime());
            $news->setTitle('Lorem ipsum dolor sit amet');
            $news->setShortDesc('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non mollis ipsum. Maecenas sed consectetur nunc. Nulla porta felis sit amet vestibulum sodales.');
            $news->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non mollis ipsum. Maecenas sed consectetur nunc. Nulla porta felis sit amet vestibulum sodales. Aenean diam tellus, tempus quis eros vel, aliquet faucibus velit. Mauris imperdiet risus id diam molestie, in suscipit nisl aliquet. Integer urna elit, sodales quis rutrum sit amet, tincidunt in tortor. Integer ac elit eros. Duis rhoncus sem ut dictum congue. Praesent sit amet efficitur orci, vitae tincidunt lacus. Aliquam quis sollicitudin urna. Nam consequat mattis nisl, cursus rhoncus augue eleifend et. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non mollis ipsum. Maecenas sed consectetur nunc. Nulla porta felis sit amet vestibulum sodales. Aenean diam tellus, tempus quis eros vel, aliquet faucibus velit. Mauris imperdiet risus id diam molestie, in suscipit nisl aliquet. Integer urna elit, sodales quis rutrum sit amet, tincidunt in tortor. Integer ac elit eros. Duis rhoncus sem ut dictum congue. Praesent sit amet efficitur orci, vitae tincidunt lacus. Aliquam quis sollicitudin urna. Nam consequat mattis nisl, cursus rhoncus augue eleifend et.');
            $news->addCategory ($randomCategory);
            $entityManager->persist($news);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_front_home');
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): Response
    {
        return $this->redirectToRoute('app_front_home');
    }

}
