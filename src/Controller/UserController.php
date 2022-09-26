<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

  /**
   * @Route("/inscription", name="user_registration")
   */
  public function registration(Request $request, ManagerRegistry $managerRegistry,
                               UserPasswordHasherInterface $hasher): Response
  {
    $user = new User();

    $form = $this->createForm(RegistrationType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $hashedPassword = $hasher->hashPassword($user, $user->getPassword());
      $user->setPassword($hashedPassword);

      $manager = $managerRegistry->getManager();
      $manager->persist($user);
      $manager->flush();

      $this->addFlash(
        'success',
        'Création de l\'utilisateur : ' . $user->getUsername() . ' [OK]'
      );

      return $this->redirectToRoute("user_login");
    }
    return $this->render('user/registration.html.twig', [
      'title' => 'Inscription',
      'registrationForm' => $form->createView()
    ]);
  }

  /**
   * @Route("/connexion", name="user_login")
   */
  public function login(AuthenticationUtils $utils): Response
  {
    return $this->render('user/login.html.twig', [
      'title' => 'Connexion',
      'last_username' => $utils->getLastUsername(),
      'error' => $utils->getLastAuthenticationError()
    ]);
  }

  /**
   * @Route("/deconnexion", name="user_logout")
   */
  public function logout() {}
}
