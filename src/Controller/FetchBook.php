<?php

declare(strict_types=1);

namespace App\Controller;

use App\Book\IFetchBook;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class FetchBook
{
    public function __construct(private IFetchBook $booksProvider, private Environment $template)
    {
    }

    public function __invoke(string $title): Response
    {
        return new Response(
            $this->template->render(
                'bookDetails.html.twig',
                [
                    'book' => $this->booksProvider->fetchBook($title),
                ]
            )
        );
    }
}
