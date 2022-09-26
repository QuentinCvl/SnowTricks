<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\TricksCategory;
use App\Entity\TricksComment;
use App\Entity\TricksImages;
use App\Entity\TricksVideos;

use App\Entity\User;
use App\Form\TricksCommentType;
use App\Form\TrickType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormTypeInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class TricksController extends AbstractController
{
  /**
   * @Route("/trick/detail/{slug}", name="trick_detail")
   */
  public function index(Trick $trick, Request $request, ManagerRegistry $managerRegistry): Response
  {
    $comment = new TricksComment();
    $form = $this->createForm(TricksCommentType::class, null, [
      "attr" => ["class" => "form-control"]
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $comment->setTrick($trick);
      $comment->setUser($this->getUser());
      $comment->setContent($form->get('content')->getData());
      $comment->setCreatedAt(new \DateTime());

      $manager = $managerRegistry->getManager();
      $manager->persist($comment);
      $manager->flush();

      $this->redirectToRoute('trick_detail', ['slug' => $trick->getSlug()]);
    }

    return $this->render('tricks/detail.html.twig', [
      'title' => 'Figure n°' . $trick->getId(),
      'trick' => $trick,
      'formComment' => $form->createView()
    ]);
  }

  /**
   * @Route("/trick/creer", name="trick_create")
   * @Route("/trick/{slug}/modifier", name="trick_update")
   */
  public function tricksForm(Trick $trick = null, Request $request, ManagerRegistry $managerRegistry):
  Response
  {
    if (!$trick) {
      $trick = new Trick();
    }

    $form = $this->createForm(TrickType::class, $trick);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $slugger = new AsciiSlugger();
      $slug = $slugger->slug($trick->getName());
      $trick->setSlug($slug);
      $trick->setCreatedAt(new \DateTime());

      $manager = $managerRegistry->getManager();
      $manager->persist($trick);
      $manager->flush();

      $this->addFlash(
        'newSuccess',
        'Création du tricks : ' . $trick->getName() . ' [OK]'
      );

      return $this->redirectToRoute("trick_detail", ["slug" => $trick->getSlug()]);
    }

    return $this->render('tricks/form.html.twig', [
      'title' => 'Creation d\'une figure',
      "formTrick" => $form->createView(),
      "exist" => $trick->getId() !== null
    ]);
  }

  /**
   * @Route("/trick/delete/{id}", name="trick_delete")
   */
  public function deleteTrick(Trick $trick, ManagerRegistry $managerRegistry): Response
  {
    $manager = $managerRegistry->getManager();
    $manager->remove($trick);
    $manager->flush();

    $this->addFlash(
      'success',
      'Suppression du tricks : ' . $trick->getName() . ' [OK]'
    );

    return $this->redirectToRoute("home");
  }
}
