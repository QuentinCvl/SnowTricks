<?php

namespace App\DataFixtures;

use App\Entity\TricksCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TricksCategoryFixtures extends Fixture
{

  public function load(ObjectManager $manager): void
  {
    $categories = array(
      array(
        "name" => "indéfini",
        "detail" => "Figure qui n'a pas été catégorisé"
      ),
      array(
        "name" => "Flips",
        "detail" => ""
      ),
      array(
        "name" => "Slides",
        "detail" => ""
      ),
      array(
        "name" => "Rotations désaxées",
        "detail" => ""
      ),
      array(
        "name" => "Rotations",
        "detail" => ""
      ),
      array(
        "name" => "Grabs",
        "detail" => ""
      ),
      array(
        "name" => "Half pipes",
        "detail" => ""
      )
    );

    for ($i = 0; $i <= count($categories) - 1; $i++) {
      $category = new TricksCategory();
      $category->setName($categories[$i]['name'])
        ->setDetail($categories[$i]['detail']);

      $manager->persist($category);

      $this->addReference($categories[$i]['name'], $category);
    }

    $manager->flush();
  }
}
