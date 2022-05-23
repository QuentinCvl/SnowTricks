<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class TrickFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    // Generate 10 Tricks
    for ($i = 1; $i <= 10; $i++) {
      $trickName = "Figure n°$i";
      $slugger = new AsciiSlugger();
      $slug = $slugger->slug($trickName);
      $trick = new Trick();
      $trick->setName($trickName)
        ->setSlug($slug)
        ->setContent("Ceci est le descriptif de la figure")
        ->setCategoryId(1)
        ->setCreatedAt(new \DateTime());

      $manager->persist($trick);
    }

    $manager->flush();
  }

}
