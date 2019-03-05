<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestCrudEntityRepository")
 */
class TestCrudEntity
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
    private $column_1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $column_2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $column_3;

    /**
     * @ORM\Column(type="json_array")
     */
    private $column_4;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColumn1(): ?string
    {
        return $this->column_1;
    }

    public function setColumn1(string $column_1): self
    {
        $this->column_1 = $column_1;

        return $this;
    }

    public function getColumn2(): ?string
    {
        return $this->column_2;
    }

    public function setColumn2(string $column_2): self
    {
        $this->column_2 = $column_2;

        return $this;
    }

    public function getColumn3(): ?string
    {
        return $this->column_3;
    }

    public function setColumn3(string $column_3): self
    {
        $this->column_3 = $column_3;

        return $this;
    }

    public function getColumn4()
    {
        return $this->column_4;
    }

    public function setColumn4($column_4): self
    {
        $this->column_4 = $column_4;

        return $this;
    }
}
