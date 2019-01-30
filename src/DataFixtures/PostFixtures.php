<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Media;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // use the factory to create a Faker\Generator instance
        $faker = \Faker\Factory::create("fr_FR");
        // creation de deux categories
        for($i=1; $i<=2; $i++){
            $category= new Category();
            $category->setTag($faker->sentence());
            $manager->persist($category);
            // creation de de 6 media url
            for($j=1; $j<=6; $j++){
                $media= new Media();
                $media->setImage($faker->imageUrl());
                $manager->persist($media);
            
                // creation de 6 post 
                for($p=1; $p<=3; $p++){
                    $post=new Post();
                    $content='<p>'.join($faker->paragraphs(5),'<p></p>').'</p>';
                    $post->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setcreatedAt($faker->dateTimeBetween(' -6 months '))
                        ->setDuration(mt_rand(1,9))
                        ->setPrice($faker->randomNumber())
                        ->setVideo($faker->imageUrl())
                        ->setStatus(mt_rand(0,1))
                        ->setMedia($media)
                        ->setCategory($category)
                        ;
                    $manager->persist($post);
                }
            }
        }

        $manager->flush();
    }
}
