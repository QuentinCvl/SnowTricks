<?php

namespace App\DataFixtures;

use App\Entity\TricksComment;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class TricksCommentFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {
    $faker = Faker\Factory::create('fr_FR');

    $comment = new TricksComment();
    $comment->setTrick($this->getReference("Front flip"))
      ->setUser($this->getReference("user-admin"))
      ->setContent($faker->sentence())
      ->setCreatedAt($faker->dateTimeBetween('-1 weeks', 'now'));

    $manager->persist($comment);
    $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      UserFixtures::class,
      TrickFixtures::class
    ];
  }
}
