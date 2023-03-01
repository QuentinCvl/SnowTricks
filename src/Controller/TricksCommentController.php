<?php

namespace App\Controller;

use App\Entity\TricksComment;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksCommentController extends AbstractController
{
  /**
   * @Route("/comment/delete/{id}", name="comment_delete")
   */
    public function delete(TricksComment $comment, ManagerRegistry $managerRegistry): Response
    {
      $slug = $comment->getTrick()->getSlug();
      $manager = $managerRegistry->getManager();
      $manager->remove($comment);
      $manager->flush();

      return $this->redirectToRoute("trick_detail", ["slug" => $slug]);
    }
}
