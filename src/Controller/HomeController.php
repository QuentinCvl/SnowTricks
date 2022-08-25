<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trick;
use App\Repository\TrickRepository;

class HomeController extends AbstractController
{
  /**
   * @Route("/", name="home")
   */
  public function index(TrickRepository $repo): Response
  {
    $tricks = $repo->findAll();

    return $this->render('home/index.html.twig', [
      'title' => 'Snow Tricks - Page d\'accueil',
      'tricks' => $tricks,
    ]);
  }
}
