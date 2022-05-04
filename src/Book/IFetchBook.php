<?php

declare(strict_types=1);

namespace App\Book;

interface IFetchBook
{
    public function fetchAllBooks(): BookList;

    public function fetchBooksByFilter(array $filters): BookList;

    public function fetchBook(string $title): ?Book;
}
