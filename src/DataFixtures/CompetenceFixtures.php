<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Competence;

class CompetenceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for($i=0;$i<=7;$i++){
            $competence = new Competence();
            $competence->setName($faker->realText(100,2));
            $manager->persist($competence);
        }

        $manager->flush();
    }
}
