<?php

namespace App\Controller;

use App\Entity\TricksCategory;
use App\Entity\TricksComment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
      'trick' => $trick,
      'commentaries' => $trick->getTrickComments(),
      'images' => $trick->getTrickImages(),
      'videos' => $trick->getTrickVideos()

    ]);
  }
}
