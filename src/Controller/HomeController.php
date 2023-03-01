<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrickRepository;

class HomeController extends AbstractController
{
  /**
   * @Route("/{page}", name="home")
   */
  public function index(TrickRepository $repo, int $page = 1): Response
  {
    $tricks = $repo->getTrickPaginator($page, '6');

    $pagination = array(
      'page' => $page,
      'nbPages' => ceil(count($tricks) / '6'),
      'params' => array()
    );

    return $this->render('home/index.html.twig', [
      'title' => 'Snow Tricks - Page d\'accueil',
      'tricks' => $tricks,
      'pagination' => $pagination
    ]);
  }
}
