<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="grades")
 */
class GradeDoctrineEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id = null;

    /** @ORM\Column(type="string", nullable=false) */
    private ?string $subject = null;

    /** @ORM\Column(type="decimal", nullable=false) */
    private ?float $value = null;

    /** @ORM\ManyToOne(targetEntity="StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\StudentDoctrineEntity", inversedBy="grades", ) */
    private ?StudentDoctrineEntity $student = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getStudent(): ?StudentDoctrineEntity
    {
        return $this->student;
    }

    public function setStudent(?StudentDoctrineEntity $student): self
    {
        $this->student = $student;

        return $this;
    }
}
