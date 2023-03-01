<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\TricksComment;
use App\Entity\TricksImages;

use App\Form\TricksCommentType;
use App\Form\TrickType;
use App\Service\FileManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TricksController extends AbstractController
{
  /**
   * @Route("/trick/detail/{slug}", name="trick_detail")
   */
  public function index(Trick $trick, Request $request, ManagerRegistry $managerRegistry): Response
  {
    $comment = new TricksComment();
    $form = $this->createForm(TricksCommentType::class);
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
      'title' => $trick->getName(),
      'trick' => $trick,
      'formComment' => $form->createView()
    ]);
  }

  /**
   * @Route("/trick/creer", name="trick_create")
   * @Route("/trick/{slug}/modifier", name="trick_update")
   */
  public function tricksForm(Trick $trick = null, Request $request, ManagerRegistry $managerRegistry,
                             SluggerInterface $slugger): Response
  {
    if (!$trick) {
      $trick = new Trick();
    }

    $form = $this->createForm(TrickType::class, $trick);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $trick->setSlug($slugger->slug($trick->getName()));
      // If new add created date, else update the updated date
      if(!$trick->getId()) {
        $trick->setCreatedAt(new \DateTime());
      } else {
        $trick->setUpdatedAt(new \DateTime());
      }
      // mainPicture
      $mainPicture = $form->get('mainPictureFile')->getData();
      if($mainPicture) {
        $fileManager = new FileManager($this->getParameter('images_directory'));
        $fileName = $fileManager->upload($mainPicture);
        $fileManager->delete($trick->getMainPicture());
        $trick->setMainPicture($fileName);
      }

      // video
      $video = $form->get('videoFile')->getData();
      if($video) {
        $fileManager = new FileManager($this->getParameter('images_directory'));
        $fileName = $fileManager->upload($video);
        $fileManager->delete($trick->getVideo());
        $trick->setVideo($fileName);
      }

      // Collection TricksImages
      $images = $form->get('images')->getData();
      foreach ($images as $img) {
        $fileManager = new FileManager($this->getParameter('images_directory'));
        $fileName = $fileManager->upload($img);
        // Persist on new TricksImages
        $newTricksImages = new TricksImages();
        $newTricksImages
          ->setTrick($trick)
          ->setSrc($fileName);

        $trick->addTrickImage($newTricksImages);
      }

      $manager = $managerRegistry->getManager();
      $manager->persist($trick);
      $manager->flush();


      $this->addFlash(
        'newSuccess',
        'Création du tricks : ' . $trick->getName()
      );

      return $this->redirectToRoute("trick_detail", ["slug" => $trick->getSlug()]);
    }

    return $this->render('tricks/form.html.twig', [
      'title' => 'Creation d\'une figure',
      'trick' => $trick,
      "formTrick" => $form->createView(),
      "exist" => $trick->getId() !== null
    ]);
  }

  /**
   * Soft delete
   * @Route("/trick/delete/{id}", name="trick_delete")
   */
  public function deleteTrick(Trick $trick, ManagerRegistry $managerRegistry): Response
  {
    $trick->setDeletedAt(new \DateTime());

    $manager = $managerRegistry->getManager();
    $manager->persist($trick);
    $manager->flush();

    $this->addFlash(
      'success',
      'Suppression du tricks : ' . $trick->getName() . ' [OK]'
    );

    return $this->redirectToRoute("home");
  }

  /**
   * @Route("/tricksImages/delete/{id}", name="tricksImages_delete")
   */
  public function deleteTricksImages(TricksImages $tricksImages, ManagerRegistry $managerRegistry): Response
  {
    $fileManager = new FileManager($this->getParameter('images_directory'));
    $fileManager->delete($tricksImages->getSrc());

    $manager = $managerRegistry->getManager();
    $manager->remove($tricksImages);
    $manager->flush();

    return $this->redirectToRoute("trick_update", ['slug' => $tricksImages->getTrick()->getSlug()]);
  }
}
