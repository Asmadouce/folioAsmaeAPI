<?php

namespace App\DataFixtures;

use App\Entity\Experiences;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ExperiencesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for($i=0;$i<=7;$i++){
            $experience = new Experiences();
            $experience->setDescriptions($faker->realText(55,2));
            $experience->setDuree($faker->realText(55,2));
            $experience->setPoste($faker->realText(55,2));
            $experience->setEntreprise($faker->realText(55,2));
            $manager->persist($experience);
        }

        $manager->flush();
    }
}