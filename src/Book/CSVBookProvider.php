<?php

declare(strict_types=1);

namespace App\Book;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class CSVBookProvider implements IFetchBook
{
    private const BOOK_FILENAME = 'book.csv';

    public function __construct(public SerializerInterface $serializer, private string $csvDataPath)
    {
    }

    public function fetchAllBooks(): BookList
    {
        return $this->fetchBooksByFilter();
    }

    public function fetchBooksByFilter(array $filters = []): BookList
    {
        $bookList = new BookList();

        foreach ($this->transformCsvBookToArray() as $book) {

            $hasFilter = true;
            foreach ($filters as $key => $value) {

                if (!array_key_exists($key, Book::MAP_PRIORITIES)) {
                    throw new \RuntimeException(sprintf('filter "%s" does not exist', $key));
                }

                if ( $value !== $book[Book::MAP_PRIORITIES[$key]]) {
                    $hasFilter = false;
                }
            }

            if ($hasFilter) {
                $book = new Book($book);
                $bookList->addBook($book);
            }

        }

        return $bookList;
    }

    private function transformCsvBookToArray(): array
    {
        $path = $this->csvDataPath . self::BOOK_FILENAME;

        return $this->serializer->decode(file_get_contents($path), 'csv', [CsvEncoder::DELIMITER_KEY => ';']);
    }

    public function fetchBook(string $title): ?Book
    {
        $books = $this->fetchBooksByFilter(['title' => $title]);


        if (count($books) > 1) {
            throw new \RuntimeException('there is more than one book associated with this title');
        }

        return $books->getIterator()[0] ?? null;
    }
}
