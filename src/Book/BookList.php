<?php

declare(strict_types=1);

namespace App\Book;

class BookList implements \IteratorAggregate, \Countable
{
    private array $books = [];

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->books);
    }

    public function addBook(Book $book): self
    {
        if (!in_array($book, $this->books)) {
            $this->books[] = $book;
        }

        return $this;
    }

    public function count(): int
    {
        return count($this->books);
    }
}
