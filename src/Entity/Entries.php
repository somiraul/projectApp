<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntriesRepository")
 */
class Entries
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $projectId;

    /**
     * @ORM\Column(type="time")
     */
    private $entry;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function setProjectId(int $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getEntry(): ?\DateTimeInterface
    {
        return $this->entry;
    }

    public function setEntry(\DateTimeInterface $entry): self
    {
        $this->entry = $entry;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

}
