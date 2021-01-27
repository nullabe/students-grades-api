<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="students")
 */
class StudentDoctrineEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id = null;

    /** @ORM\Column(type="string", unique=true)  */
    private ?string $uuid = null;

    /** @ORM\Column(type="string", nullable=false) */
    private ?string $firstName = null;

    /** @ORM\Column(type="string", nullable=false) */
    private ?string $lastName = null;

    /** @ORM\Column(type="datetime", nullable=false) */
    private ?\DateTimeInterface $birthDate = null;

    /**
     * @var Collection<int, GradeDoctrineEntity>
     * @ORM\OneToMany(targetEntity="StudentsGradesApi\Infrastructure\Persistence\Doctrine\Entity\GradeDoctrineEntity", mappedBy="student", cascade={"persist", "remove"})
     */
    private Collection $grades;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return Collection<int, GradeDoctrineEntity>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    /**
     * @param Collection<int, GradeDoctrineEntity> $grades
     */
    public function setGrades(Collection $grades): self
    {
        $this->grades = $grades;

        return $this;
    }

    public function addGrade(GradeDoctrineEntity $grade): self
    {
        $this->grades->add($grade);

        return $this;
    }
}
