<?php

namespace App\DataFixtures;

use App\Entity\Trick;
Use App\Entity\TricksCategory;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Faker;

class TrickFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $faker = Faker\Factory::create('FR_fr');

    // Generate 10 Tricks
    $tricks = [
      array(
        "name" => "Front flip",
        "category" => 2
      ),
      array(
        "name" => "Back flip",
        "category" => 2
      ),
      array(
        "name" => "Air to Fakie",
        "category" => 7
      ),
      array(
        "name" => "Cork",
        "category" => 4
      ),
      array(
        "name" => "Grab Indy",
        "category" => 6
      ),
      array(
        "name" => "Lipslide",
        "category" => 3
      ),
      array(
        "name" => "Noseslide",
        "category" => 3
      ),
      array(
        "name" => "Rodeoback",
        "category" => 5
      ),
      array(
        "name" => "Underflip",
        "category" => 1
      ),
      array(
        "name" => "Stalefish",
        "category" => 6
      )
    ];

    for ($i = 1; $i <= count($tricks); $i++) {
      $trickName = $tricks[$i]['name'];

      $slugger = new AsciiSlugger();
      $slug = $slugger->slug($trickName);

      $content = '<p>';
      $content .= join($faker->paragraphs(5), '<p></p>');
      $content .= '</p>';

      $trick = new Trick();
      $trick->setName($trickName)
        ->setSlug($slug)
        ->setContent($content)
        ->setCategory($tricks[$i]['category'])
        ->setCreatedAt($faker->dateTimeBetween('-3 mouths'));

      $manager->persist($trick);
    }

    $manager->flush();
  }
}
