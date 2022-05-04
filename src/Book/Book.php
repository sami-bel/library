<?php

declare(strict_types=1);

namespace App\Book;

class Book
{
    public const MAP_PRIORITIES = [
        'title' => 'titre',
        'author' => 'auteur',
        'genre' => 'genre',
        'year' => 'année de publication'
    ];

    public function __construct(private array $book)
    {
    }

    public function getTitle(): string
    {
        if (!array_key_exists('titre', $this->book)) {
            throw new \RuntimeException('titre key does not exist');
        }

        return $this->book['titre'];
    }

    public function getAuthor(): string
    {
        if (!array_key_exists('auteur', $this->book)) {
            throw new \RuntimeException('auteur key does not exist');
        }

        return $this->book['auteur'];
    }

    public function getGenre(): string
    {
        if (!array_key_exists('genre', $this->book)) {
            throw new \RuntimeException('genre key does not exist');
        }

        return $this->book['genre'];
    }

    public function getYear(): string
    {
        if (!array_key_exists('année de publication', $this->book)) {
            throw new \RuntimeException('année de publication key does not exist');
        }

        return $this->book['année de publication'];
    }
}
