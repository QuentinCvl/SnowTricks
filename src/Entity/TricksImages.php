<?php

namespace App\Entity;

use App\Repository\TricksImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TricksImagesRepository::class)
 */
class TricksImages
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="trickImages")
   * @ORM\JoinColumn(nullable=false)
   */
  private $trick;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $src;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $position;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTrick(): ?Trick
  {
    return $this->trick;
  }

  public function setTrick(?Trick $trick): self
  {
    $this->trick = $trick;

    return $this;
  }

  public function getSrc(): ?string
  {
    return $this->src;
  }

  public function setSrc(string $src): self
  {
    $this->src = $src;

    return $this;
  }

  public function getPosition(): ?int
  {
    return $this->position;
  }

  public function setPosition(?int $position): self
  {
    $this->position = $position;

    return $this;
  }
}
