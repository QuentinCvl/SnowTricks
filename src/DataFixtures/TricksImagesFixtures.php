<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Entity\TricksImages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TricksImagesFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {
    $images = array(
      array(
        "trick" => "Front flip",
        "images" => ["flip/frontflip.jpg"],
      ),
      array(
        "trick" => "Back flip",
        "images" => ["flip/backflip.jpg"],
      ),
      array(
        "trick" => "Air to Fakie",
        "images" => ["half-pipes/air_fakie.jpg"],
      ),
      array(
        "trick" => "Cork",
        "images" => ["rotations-desaxees/cork.jpg"],
      ),
      array(
        "trick" => "Grab Indy",
        "images" => ["grab/grab-indy.jpeg"],
      ),
      array(
        "trick" => "Lipslide",
        "images" => ["slides/lipslide.jpeg"],
      ),
      array(
        "trick" => "Noseslide",
        "images" => ["slides/noseslide.jpeg"],
      ),
      array(
        "trick" => "Rodeoback",
        "images" => ["rotations/rodeoback.jpeg"]
      ),
      array(
        "trick" => "Underflip",
        "images" => ["undefined/underflip.jpeg"]
      ),
      array(
        "trick" => "Stalefish",
        "images" => ["grab/stalefish.jpg"]
      )
    );

    for ($i = 0; $i < count($images); $i++) {
      $img = new TricksImages();
      $img->setTrick($this->getReference($images[$i]['trick']));

      for ($j = 0; $j < count($images[$i]["images"]); $j++) {
        $img->setSrc($images[$i]["images"][$j])
          ->setPosition($j + 1);
      }

      $manager->persist($img);
    }

    $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      TrickFixtures::class,
    ];
  }
}
