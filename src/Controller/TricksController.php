<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrickRepository;
use App\Entity\Trick;

class TricksController extends AbstractController
{
  /**
   * @Route("/tricks/detail/{slug}", name="tricks_detail")
   */
  public function index(Trick $trick): Response
  {
    return $this->render('tricks/detail.html.twig', [
      'controller_name' => 'TricksController',
      'title' => 'Figure n°'. $trick->getId(),
      'trick' => $trick
    ]);
  }
}
