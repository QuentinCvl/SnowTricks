<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trick;

class HomeController extends AbstractController
{
  /**
   * @Route("/", name="home")
   */
  public function index(): Response
  {
    $repo = $this->getDoctrine()->getRepository(Trick::class);
    $tricks = $repo->findAll();

    return $this->render('home/index.html.twig', [
      'title' => 'Snow Tricks - Page d\'accueil',
      'tricks' => $tricks
    ]);
  }
}
