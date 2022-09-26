<?php

namespace App\DataFixtures;

use App\Entity\TricksVideos;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TricksVideosFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
      $comment = new TricksVideos();
      $comment->setTrick($this->getReference("Front flip"))
        ->setSrc("flip/snowTrick.mp4");

      $manager->persist($comment);
      $manager->flush();
    }

  public function getDependencies(): array
  {
    return [
      TrickFixtures::class
    ];
  }
}
