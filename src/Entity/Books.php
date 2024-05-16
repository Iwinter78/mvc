<?php

namespace App\Entity;

use Exception;
use App\Repository\BooksRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BooksRepository::class)]
class Books
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $isbn = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIsbn(): ?int
    {
        return $this->isbn;
    }
    /**
     * @param int $isbn
     */
    public function setIsbn(int $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Adds a book to the database
     *
     * @param array<string, mixed> $data
     * @return void
     */
    public function addBook(array $data): void
    {
        if (isset($data['title'], $data['isbn'], $data['author'], $data['image'])) {
            $this->setName($data['title']);
            $this->setIsbn($data['isbn']);
            $this->setAuthor($data['author']);
            $this->setImage($data['image']);
        }
    }
}
