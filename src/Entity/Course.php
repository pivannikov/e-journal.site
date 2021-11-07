<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToMany(targetEntity=Faculty::class, inversedBy="courses")
     */
    private $faculty;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="course")
     */
    private $groups;

    public function __construct()
    {
        $this->faculty = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection|Faculty[]
     */
    public function getFaculty(): Collection
    {
        return $this->faculty;
    }

    public function addFaculty(Faculty $faculty): self
    {
        if (!$this->faculty->contains($faculty)) {
            $this->faculty[] = $faculty;
        }

        return $this;
    }

    public function removeFaculty(Faculty $faculty): self
    {
        $this->faculty->removeElement($faculty);

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->setCourse($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getCourse() === $this) {
                $group->setCourse(null);
            }
        }

        return $this;
    }
}
