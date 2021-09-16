<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ORM\Table(name="`message`")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=350)
     */
    private $message;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRead;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateAdd;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sentMessages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sender", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $sender;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="receivedMessages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="receiver", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $receiver;

    public function __construct()
    {
        $this->isRead = false;
        $this->dateAdd = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }


}
