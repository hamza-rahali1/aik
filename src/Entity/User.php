<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *   fields={"email"},
 *   message="An other user is already registred with this email address"
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
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\Length(min=4 , minMessage="Password too short! Password need to have at least 4 characters.")
     */
    private $hash;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Please insert a valid email !")
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Testimanial", mappedBy="author", orphanRemoval=true)
     */
    private $testimanials;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="destination", orphanRemoval=true)
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Property", inversedBy="clients")
     */
    private $favories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;


    /**
     * @Assert\EqualTo(propertyPath="hash", message="Wrong password confirmation! Please check your password.")
     */
    public $passwordcomfirm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $otherEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="author")
     */
    private $myMessages;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="applicant")
     */
    private $applications;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $answered;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->testimanials = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->favories = new ArrayCollection();
        $this->myMessages = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug() {
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->firstName . ' ' . $this->lastName);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Testimanial[]
     */
    public function getTestimanials(): Collection
    {
        return $this->testimanials;
    }

    public function addTestimanial(Testimanial $testimanial): self
    {
        if (!$this->testimanials->contains($testimanial)) {
            $this->testimanials[] = $testimanial;
            $testimanial->setAuthor($this);
        }

        return $this;
    }

    public function removeTestimanial(Testimanial $testimanial): self
    {
        if ($this->testimanials->contains($testimanial)) {
            $this->testimanials->removeElement($testimanial);
            // set the owning side to null (unless already changed)
            if ($testimanial->getAuthor() === $this) {
                $testimanial->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setDestination($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getDestination() === $this) {
                $message->setDestination(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getFavories(): Collection
    {
        return $this->favories;
    }

    public function addFavory(Property $favory): self
    {
        if (!$this->favories->contains($favory)) {
            $this->favories[] = $favory;
        }

        return $this;
    }

    public function removeFavory(Property $favory): self
    {
        if ($this->favories->contains($favory)) {
            $this->favories->removeElement($favory);
        }

        return $this;
    }

    public function getRole()
    {
        return $this->roles;
    }

    public function getRoles()
    {
        $rolesArray[] = $this->roles;
        return $rolesArray;
    }

    public function setRole(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword()
    {
        return $this->hash;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials() {}

    public function getSalt() {}

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getOtherEmail(): ?string
    {
        return $this->otherEmail;
    }

    public function setOtherEmail(?string $otherEmail): self
    {
        $this->otherEmail = $otherEmail;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMyMessages(): Collection
    {
        return $this->myMessages;
    }

    public function addMyMessage(Message $myMessage): self
    {
        if (!$this->myMessages->contains($myMessage)) {
            $this->myMessages[] = $myMessage;
            $myMessage->setAuthor($this);
        }

        return $this;
    }

    public function removeMyMessage(Message $myMessage): self
    {
        if ($this->myMessages->contains($myMessage)) {
            $this->myMessages->removeElement($myMessage);
            // set the owning side to null (unless already changed)
            if ($myMessage->getAuthor() === $this) {
                $myMessage->setAuthor(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setApplicant($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getApplicant() === $this) {
                $application->setApplicant(null);
            }
        }

        return $this;
    }

    public function getAnswered(): ?bool
    {
        return $this->answered;
    }

    public function setAnswered(?bool $answered): self
    {
        $this->answered = $answered;

        return $this;
    }

}
