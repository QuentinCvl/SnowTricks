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
        "category" => "Flips",
        "mainPicture" => "frontflip.jpg",
        "video" => "snowTrick.mp4"
      ),
      array(
        "name" => "Back flip",
        "category" => "Flips",
        "mainPicture" => "backflip.jpg",
        "video" => ""
      ),
      array(
        "name" => "Air to Fakie",
        "category" => "Half pipes",
        "mainPicture" => "air_fakie.jpg",
        "video" => ""
      ),
      array(
        "name" => "Cork",
        "category" => "Rotations désaxées",
        "mainPicture" => "cork.jpg",
        "video" => ""
      ),
      array(
        "name" => "Grab Indy",
        "category" => "Grabs",
        "mainPicture" => "grab-indy.jpeg",
        "video" => ""
      ),
      array(
        "name" => "Lipslide",
        "category" => "Slides",
        "mainPicture" => "lipslide.jpeg",
        "video" => ""
      ),
      array(
        "name" => "Noseslide",
        "category" => "Slides",
        "mainPicture" => "noseslide.jpeg",
        "video" => ""
      ),
      array(
        "name" => "Rodeoback",
        "category" => "Rotations",
        "mainPicture" => "rodeoback.jpeg",
        "video" => ""
      ),
      array(
        "name" => "Underflip",
        "category" => "indéfini",
        "mainPicture" => "underflip.jpeg",
        "video" => ""
      ),
      array(
        "name" => "Stalefish",
        "category" => "Grabs",
        "mainPicture" => "stalefish.jpg",
        "video" => ""
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
        ->setMainPicture($tricks[$i]['mainPicture'])
        ->setCategory($this->getReference($tricks[$i]['category']))
        ->setCreatedAt($faker->dateTimeBetween('-6 weeks', 'now'));

      if($tricks[$i]['video']) {
        $trick->setVideo($tricks[$i]['video']);
      }

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
