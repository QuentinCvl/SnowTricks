<?php

namespace App\DataFixtures;

use App\Entity\TricksImages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TricksImagesFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $images = array(
      array(
        "trick_id" => 1, //"Front flip"
        "src" => "flip/frontflip.jpg",
        "position" => 1
      ),
      array(
        "trick_id" => 2, //"Back flip"
        "src" => "flip/frontflip.jpg",
        "position" => 1
      ),
      array(
        "trick_id" => 3, //"Air to Fakie"
        "src" => "half-pipes/air_fakie.jpg",
        "position" => 1
      ),
      array(
        "trick_id" => 4, //"Cork"
        "src" => "rotations-desaxees/cork.jpg",
        "position" => 1
      ),
      array(
        "trick_id" => 5, //"Grab Indy"
        "src" => "grab/grab-indy.jpeg",
        "position" => 1
      ),
      array(
        "trick_id" => 6, //"Lipslide"
        "src" => "slides/lipslide.jpeg",
        "position" => 1
      ),
      array(
        "trick_id" => 7, //"Noseslide"
        "src" => "slides/noseslide.jpeg",
        "position" => 1
      ),
      array(
        "trick_id" => 8, //"Rodeoback"
        "src" => "rotations/rodeoback.jpeg",
        "position" => 1
      ),
      array(
        "trick_id" => 9, //"Underflip"
        "src" => "undefined/underflip.jpeg",
        "position" => 1
      ),
      array(
        "trick_id" => 10, //"Stalefish"
        "src" => "grab/stalefish.jpg",
        "position" => 1
      )
    );

    for ($i = 1; $i <= count($images); $i++) {
      $img = new TricksImages();
      $img->setTrickId($images[$i]['trick_id'])
        ->setSrc($images[$i]['src'])
        ->setPosition($images[$i]['position']);

      $manager->persist($img);
    }

    $manager->flush();
  }
}
