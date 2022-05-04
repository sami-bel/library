<?php

namespace Tests\Book;


use App\Book\IFetchBook;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CSVBookProviderTest extends WebTestCase
{

    private IFetchBook $csvBookProvider;

    public function setUp(): void
    {
        static::bootKernel();

        $this->csvBookProvider = static::getContainer()->get(IFetchBook::class);
    }

    public function test_fetch_all_books(): void
    {
        $content = "titre;auteur;année de publication;genre
title1;author1;2014;genre1
title2;author2;2014;genre2";
        $this->createCSVData($content);

        $books = $this->csvBookProvider->fetchAllBooks();
        $this->assertCount(2, $books);

        $book1 = $books->getIterator()[0];
        $this->assertEquals('title1', $book1->getTitle());
        $this->assertEquals('genre1', $book1->getGenre());
        $this->assertEquals('author1', $book1->getAuthor());
        $this->assertEquals('2014', $book1->getYear());

        $book1 = $books->getIterator()[1];
        $this->assertEquals('title2', $book1->getTitle());
        $this->assertEquals('genre2', $book1->getGenre());
        $this->assertEquals('author2', $book1->getAuthor());
        $this->assertEquals('2014', $book1->getYear());
    }

    public function test_fetch_by_filters(): void
    {
        $content = "titre;auteur;année de publication;genre
title1;author1;2014;genre1
title2;author2;2012;genre2
title3;author1;2014;genre3
title4;author4;2014;genre1";

        $this->createCSVData($content);

        $books = $this->csvBookProvider->fetchBooksByFilter(['author' => 'author1']);
        $this->assertCount(2, $books);

        $book1 = $books->getIterator()[0];
        $this->assertEquals('title1', $book1->getTitle());
        $this->assertEquals('genre1', $book1->getGenre());
        $this->assertEquals('author1', $book1->getAuthor());
        $this->assertEquals('2014', $book1->getYear());

        $book1 = $books->getIterator()[1];
        $this->assertEquals('title3', $book1->getTitle());
        $this->assertEquals('genre3', $book1->getGenre());
        $this->assertEquals('author1', $book1->getAuthor());
        $this->assertEquals('2014', $book1->getYear());

        $books = $this->csvBookProvider->fetchBooksByFilter(['year' => '2014']);
        $this->assertCount(3, $books);

        $books = $this->csvBookProvider->fetchBooksByFilter(['genre' => 'genre1']);
        $this->assertCount(2, $books);

        $books = $this->csvBookProvider->fetchBooksByFilter(['genre' => 'other genre']);
        $this->assertCount(0, $books);


    }

    public function test_fetch_book(): void
    {
        $content = "titre;auteur;année de publication;genre
title1;author1;2014;genre1
title2;author2;2014;genre2";

        $this->createCSVData($content);

        $book = $this->csvBookProvider->fetchBook('title1');

        $this->assertEquals('title1', $book->getTitle());
        $this->assertEquals('genre1', $book->getGenre());
        $this->assertEquals('author1', $book->getAuthor());
        $this->assertEquals('2014', $book->getYear());


        $book = $this->csvBookProvider->fetchBook('other title');
        $this->assertNull($book);
    }

    public function test_fetch_book_does_throw_exception(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('there is more than one book associated with this title');

        $content = "titre;auteur;année de publication;genre
title1;author1;2014;genre1
title1;author2;2014;genre2";

        $this->createCSVData($content);
        $this->csvBookProvider->fetchBook('title1');
    }

    private function createCSVData(string $content): void
    {
        $dir = static::getContainer()->getParameter('csv_data_path');
        $bookFile = fopen(sprintf('%s%s', $dir, 'book.csv'), 'w');
        fwrite($bookFile, $content);
        fclose($bookFile);
    }

}
