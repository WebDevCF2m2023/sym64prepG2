<?php
// src/Entity/Section.php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        options:
        [
            'unsigned' => true,
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 160)]
    private ?string $sectionTitle = null;

    #[ORM\Column(length: 600, nullable: true)]
    private ?string $sectionDescription = null;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'sections')]
    private Collection $posts;

    #[ORM\Column(
        length: 162,
        unique: true,
    )]
    private ?string $sectionSlug = null;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSectionTitle(): ?string
    {
        return $this->sectionTitle;
    }

    public function setSectionTitle(string $sectionTitle): static
    {
        $this->sectionTitle = $sectionTitle;

        return $this;
    }

    public function getSectionDescription(): ?string
    {
        return $this->sectionDescription;
    }

    public function setSectionDescription(?string $sectionDescription): static
    {
        $this->sectionDescription = $sectionDescription;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->addSection($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            $post->removeSection($this);
        }

        return $this;
    }

    public function getSectionSlug(): ?string
    {
        return $this->sectionSlug;
    }

    public function setSectionSlug(string $sectionSlug): static
    {
        $this->sectionSlug = $sectionSlug;

        return $this;
    }
}
