<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    /**
     * property to hold id
     */
    private ?int $id = null;
    /**
     * property to hold title
     */
    #[ORM\Column(length: 255)]
    private ?string $title = null;
    /**
     * property to hold isbn
     */
    #[ORM\Column(length: 255)]
    private ?string $isbn = null;
    /**
     * property to hold author
     */
    #[ORM\Column(length: 255)]
    private ?string $author = null;
    /**
     * property to hold img-url
     */
    #[ORM\Column(length: 255)]
    private ?string $img = null;
    /**
     * method to get id
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * method to get title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    /**
     * method to set title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    /**
     * method to get isbn
     */
    public function getIsbn(): ?string
    {
        return $this->isbn;
    }
    /**
     * method to set isbn
     */
    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }
    /**
     * method to get author
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }
    /**
     * method to set author
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }
    /**
     * method to get img
     */
    public function getImg(): ?string
    {
        return $this->img;
    }
    /**
     * method to set img
     */
    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }
}
