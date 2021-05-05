<?php

namespace App\Entity;

use App\Repository\CustomerUserRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CustomerUserRepository::class)
 */
class CustomerUser
{
    /**
     * @OA\Property(type="integer", description="The unique identifier of the customer user.")
     * @Groups({"read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @OA\Property(type="string", description="The email of the customer user.", maxLength=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @OA\Property(type="string", description="The password of the customer user.", maxLength=255)
     * @Assert\NotBlank()
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @OA\Property(type="string", description="The firstname of the customer user.", maxLength=255)
     * @Assert\NotBlank()
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @OA\Property(type="string", description="The lastname of the customer user.", maxLength=255)
     * @Assert\NotBlank()
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="customerUsers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
