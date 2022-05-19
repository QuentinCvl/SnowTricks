<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
  /**
   * @Route("/tricks/detail/{slug}", name="tricks_detail")
   */
  public function index($slug = false): Response
  {
    return $this->render('tricks/detail.html.twig', [
      'controller_name' => 'TricksController',
      'title' => "Tricks $slug",
      'slug' => $slug
    ]);
  }
}
