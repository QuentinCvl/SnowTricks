<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TricksCategory;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TrickType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add("name", TextType::class,
        [
          "attr" => ["placeholder" => "Nom de la figure"],
          "required" => true,
          "label" => "Nom"
        ]
      )
      ->add("content", TextareaType::class,
        [
          "attr" => ["placeholder" => "Description de la figure", "style" => "min-height: 150px"],
          "required" => true,
          "label" => "Contenu"
        ]
      )
      ->add("category", EntityType::class,
        [
          "class" => TricksCategory::class,
          "choice_label" => "name",
          "required" => true,
          "label" => "Catégorie"
        ]
      )
      ->add("mainPictureFile", FileType::class,
        [
          "required" => false,
          "label" => "Image principale",
          "attr" => [
            'accept' => "image/png, image/jpg, image/jpeg"
          ]
        ]
      )
      ->add("images", FileType::class,
        [
          "label" => "Image(s) supplémentaire",
          "attr" => [
            'accept' => "image/png, image/jpg, image/jpeg"
          ],
          'multiple' => true,
          'mapped' => false,
          'required' => false
        ]
      )
      ->add("videoFile", FileType::class,
        [
          "label" => "Vidéo",
          "attr" => [
            'accept' => "video/mp4, video/x-m4v, video/*"
          ],
          "required" => false
        ]
      );
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Trick::class,
    ]);
  }
}
