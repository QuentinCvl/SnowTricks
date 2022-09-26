<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Adresse email déjà utilisé")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\Length(min=4, minMessage="Le nom d'utilisateur doit contenir au minimum 8 caractères")
   */
  private $username;

  /**
   * @ORM\Column(type="string", length=255, unique=true)
   */
  private $email;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\Length(min=8, minMessage="Votre mot de passe doit contenir au minimum 8 caractères")
   */
  private $password;

  /**
   * @Assert\EqualTo(propertyPath="password", message="Vos mots de passe doivent être identique")
   */
  public $confirm_password;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getUsername(): ?string
  {
    return $this->username;
  }

  public function setUsername(string $username): self
  {
    $this->username = $username;

    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;

    return $this;
  }

  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(string $password): self
  {
    $this->password = $password;

    return $this;
  }

  public function getRoles()
  {
    return ['ROLE_USER'];
  }

  public function getSalt()
  {
    return null;
  }

  public function eraseCredentials()
  {
    // TODO: Implement eraseCredentials() method.
  }

  public function __call($name, $arguments)
  {
    // TODO: Implement @method string getUserIdentifier()
  }
}
