<?php

namespace App\DataFixtures;

use App\Entity\Trick;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Faker;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {
    $faker = Faker\Factory::create('fr_FR');

    // Generate 10 Tricks
    $tricks = [
      array(
        "name" => "Front flip",
        "category" => "Flips"
      ),
      array(
        "name" => "Back flip",
        "category" => "Flips"
      ),
      array(
        "name" => "Air to Fakie",
        "category" => "Half pipes"
      ),
      array(
        "name" => "Cork",
        "category" => "Rotations désaxées"
      ),
      array(
        "name" => "Grab Indy",
        "category" => "Grabs"
      ),
      array(
        "name" => "Lipslide",
        "category" => "Slides"
      ),
      array(
        "name" => "Noseslide",
        "category" => "Slides"
      ),
      array(
        "name" => "Rodeoback",
        "category" => "Rotations"
      ),
      array(
        "name" => "Underflip",
        "category" => "indéfini"
      ),
      array(
        "name" => "Stalefish",
        "category" => "Grabs"
      )
    ];

    for ($i = 0; $i < count($tricks); $i++) {
      $trickName = $tricks[$i]['name'];

      $slugger = new AsciiSlugger();
      $slug = $slugger->slug($trickName);

      $content = '<p>'. join("<p></p>", $faker->paragraphs()) .'</p>';

      $trick = new Trick();
      $trick->setName($trickName)
        ->setSlug($slug)
        ->setContent($content)
        ->setCategory($this->getReference($tricks[$i]['category']))
        ->setCreatedAt($faker->dateTimeBetween('-6 weeks', 'now'));

      $manager->persist($trick);

      $this->addReference($tricks[$i]['name'], $trick);
    }

    $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      TricksCategoryFixtures::class,
    ];
  }
}
