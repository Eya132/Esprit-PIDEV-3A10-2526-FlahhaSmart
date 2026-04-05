<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    private ?string $nom = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: "string", length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: "string", length: 50)]
    private ?string $role = 'CLIENT';

    #[ORM\Column(type: "boolean")]
    private ?bool $actif = true;

    #[ORM\Column(type: "datetime_immutable")]
    private ?\DateTimeImmutable $date_creation = null;

    public function __construct()
    {
        $this->date_creation = new \DateTimeImmutable();
        $this->actif = true;
    }

    // GETTERS
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->date_creation;
    }

    public function getFullName(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    // SETTERS
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;
        return $this;
    }

    public function setDateCreation(\DateTimeImmutable $date_creation): self
    {
        $this->date_creation = $date_creation;
        return $this;
    }

    // UserInterface methods
    public function getRoles(): array
    {
        $roles = ['ROLE_USER'];
        
        if ($this->role === 'ADMINISTRATEUR') {
            $roles[] = 'ROLE_ADMIN';
        } elseif ($this->role === 'AGRICULTEUR') {
            $roles[] = 'ROLE_AGRICULTEUR';
        } elseif ($this->role === 'CLIENT') {
            $roles[] = 'ROLE_CLIENT';
        }
        
        return $roles;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }
}