<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource(
 *      collectionOperations={},
 *     itemOperations={
 *         "get"={"path"="/user/{id}", "security"="object.getUsername() === user.getUsername()"},
 *         "put"={"path"="/user/{id}","security"="object.getUsername() === user.getUsername()"},
 *         "delete"={"path"="/user/{id}","security"="object.getUsername() === user.getUsername()"}
 *     }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Credentials", mappedBy="user")
     */
    private $credentials;

    public function __construct()
    {
        $this->credentials = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Credentials[]
     */
    public function getCredentials(): Collection
    {
        return $this->credentials;
    }

    public function addCredential(Credentials $credential): self
    {
        if (!$this->credentials->contains($credential)) {
            $this->credentials[] = $credential;
            $credential->setUser($this);
        }

        return $this;
    }

    public function removeCredential(Credentials $credential): self
    {
        if ($this->credentials->contains($credential)) {
            $this->credentials->removeElement($credential);
            // set the owning side to null (unless already changed)
            if ($credential->getUser() === $this) {
                $credential->setUser(null);
            }
        }

        return $this;
    }
}
