<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private $anywordhere;

    #[ORM\Column(type: 'text')]
    private $question;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $askedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAnywordhere(): ?string
    {
        return $this->anywordhere;
    }

    public function setAnywordhere(string $anywordhere): self
    {
        $this->anywordhere = $anywordhere;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAskedAt(): ?\DateTimeImmutable
    {
        return $this->askedAt;
    }

    public function setAskedAt(?\DateTimeImmutable $askedAt): self
    {
        $this->askedAt = $askedAt;

        return $this;
    }
}
