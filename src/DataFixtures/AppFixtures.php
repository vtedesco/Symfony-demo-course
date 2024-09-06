<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\News;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createCategories($manager);
        $this->createNews($manager);
        $this->createComments($manager);
    }
    private function createCategories(ObjectManager $manager){
        $titles = ['World','Europe','Sport','Economy'];
        foreach ($titles as $title){
            $category = new Category();
            $category->setTitle($title);
            $manager->persist($category);
        }
        $manager->flush();

        return true;
    }

    private function createNews(ObjectManager $manager){
        $categories = $manager->getRepository(Category::class)->findAll();


        foreach (range(1, 100) as $i){
            $randomCategory1 = $categories[array_rand($categories,1)];
            $randomCategory2 = $categories[array_rand($categories,1)];

            $news = new News();
            $news->setInsertDate(new \DateTime());
            $news->setTitle('Lorem ipsum dolor sit amet');
            $news->setShortDesc('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non mollis ipsum. Maecenas sed consectetur nunc. Nulla porta felis sit amet vestibulum sodales.');
            $news->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non mollis ipsum. Maecenas sed consectetur nunc. Nulla porta felis sit amet vestibulum sodales. Aenean diam tellus, tempus quis eros vel, aliquet faucibus velit. Mauris imperdiet risus id diam molestie, in suscipit nisl aliquet. Integer urna elit, sodales quis rutrum sit amet, tincidunt in tortor. Integer ac elit eros. Duis rhoncus sem ut dictum congue. Praesent sit amet efficitur orci, vitae tincidunt lacus. Aliquam quis sollicitudin urna. Nam consequat mattis nisl, cursus rhoncus augue eleifend et. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non mollis ipsum. Maecenas sed consectetur nunc. Nulla porta felis sit amet vestibulum sodales. Aenean diam tellus, tempus quis eros vel, aliquet faucibus velit. Mauris imperdiet risus id diam molestie, in suscipit nisl aliquet. Integer urna elit, sodales quis rutrum sit amet, tincidunt in tortor. Integer ac elit eros. Duis rhoncus sem ut dictum congue. Praesent sit amet efficitur orci, vitae tincidunt lacus. Aliquam quis sollicitudin urna. Nam consequat mattis nisl, cursus rhoncus augue eleifend et.');
            $news->setViews(0);
            $news->addCategory ($randomCategory1);
            $news->addCategory ($randomCategory2);
            $manager->persist($news);
        }
        $manager->flush();

        return true;

    }

    private function createComments(ObjectManager $manager){

        $newsList = $manager->getRepository(News::class)->findAll();
        foreach ($newsList as $news) {
            foreach (range(1, rand(1,10)) as $i) {
                $manager->flush();

                $comment = new Comment();
                $comment->setNews($news);
                $comment->setContent('Curabitur in fermentum diam, vitae rhoncus augue. Vestibulum ac malesuada orci.');
                $manager->persist($comment);
            }
        }
        $manager->flush();

        return true;

    }

}
