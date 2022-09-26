<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TricksCategory;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          ->add("name", TextType::class, [
            "attr" => ["placeholder" => "Nom de la figure"]
          ])
          ->add("content", TextareaType::class, [
            "attr" => ["placeholder" => "Description de la figure"]
          ])
          ->add("category", EntityType::class, [
            "class" => TricksCategory::class,
            "choice_label" => "name"
          ])
          /*->add("trickImages", CollectionType::class, [
            "entry_type" => FileType::class,
            "data_class" => null,
            "allow_add" => true
          ])
          ->add("trickVideos", CollectionType::class, [
            "entry_type" => FileType::class,
            "data_class" => null,
            "allow_add" => true
          ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
