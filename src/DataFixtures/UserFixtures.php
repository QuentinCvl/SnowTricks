<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
  public const USER_REFERENCE = 'user-admin';

  public function load(ObjectManager $manager): void
  {
    $user = new User();
    $user->setUsername("Quentin Cuvelier")
      ->setEmail("quentincuvelier@laposte.net")
      ->setPassword("%1234%");

    $this->addReference(self::USER_REFERENCE, $user);

    $manager->persist($user);
    $manager->flush();
  }
}
