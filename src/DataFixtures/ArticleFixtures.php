<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=10;$i++)
        {
            $article=new Article();
            $article ->setTitle("Titre de l'article n° $i")
                ->setContent("<p>Le contenu de l'article n° $i</p>")

                ->setImage("https://png.pngtree.com/png-vector/20221213/ourmid/pngtree-tunisia-circle-flag-vector-png-image_6522915.png")

                ->setCreatedAt(new \DateTimeImmutable());
                $manager->persist($article);
        }
        $manager->flush();
    }
}
