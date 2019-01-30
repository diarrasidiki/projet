<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="category")
     */
    private $post;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UnderCategory", mappedBy="categories")
     */
    private $underCategories;

    // /**
    //  * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="category")
    //  */
    // private $post;

    public function __construct()
    {
        $this->post = new ArrayCollection();
        $this->underCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->post->contains($post)) {
            $this->post[] = $post;
            $post->setCategory($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->post->contains($post)) {
            $this->post->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getCategory() === $this) {
                $post->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UnderCategory[]
     */
    public function getUnderCategories(): Collection
    {
        return $this->underCategories;
    }

    public function addUnderCategory(UnderCategory $underCategory): self
    {
        if (!$this->underCategories->contains($underCategory)) {
            $this->underCategories[] = $underCategory;
            $underCategory->setCategories($this);
        }

        return $this;
    }

    public function removeUnderCategory(UnderCategory $underCategory): self
    {
        if ($this->underCategories->contains($underCategory)) {
            $this->underCategories->removeElement($underCategory);
            // set the owning side to null (unless already changed)
            if ($underCategory->getCategories() === $this) {
                $underCategory->setCategories(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection|Post[]
    //  */
    // public function getPost(): Collection
    // {
    //     return $this->post;
    // }

    // public function addPost(Post $post): self
    // {
    //     if (!$this->post->contains($post)) {
    //         $this->post[] = $post;
    //         $post->setCategory($this);
    //     }

    //     return $this;
    // }

    // public function removePost(Post $post): self
    // {
    //     if ($this->post->contains($post)) {
    //         $this->post->removeElement($post);
    //         // set the owning side to null (unless already changed)
    //         if ($post->getCategory() === $this) {
    //             $post->setCategory(null);
    //         }
    //     }

    //     return $this;
    // }
}
