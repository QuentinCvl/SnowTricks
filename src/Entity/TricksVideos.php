<?php

namespace App\Entity;

use App\Repository\TricksVideosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TricksVideosRepository::class)
 */
class TricksVideos
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="trickVideos")
   * @ORM\JoinColumn(nullable=false)
   */
  private $trick;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $src;

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
}
