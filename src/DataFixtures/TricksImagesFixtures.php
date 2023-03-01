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
        "images" => ["frontflip2.jpg"]
      )
    );

    for ($i = 0; $i < count($images); $i++) {
      $img = new TricksImages();
      $img->setTrick($this->getReference($images[$i]['trick']));

      for ($j = 0; $j < count($images[$i]["images"]); $j++) {
        $img->setSrc($images[$i]["images"][$j]);
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
