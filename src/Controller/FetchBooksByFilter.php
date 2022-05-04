<?php

declare(strict_types=1);

namespace App\Controller;

use App\Book\IFetchBook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class FetchBooksByFilter
{
    public function __construct(private IFetchBook $booksProvider, private Environment $template)
    {
    }

    public function __invoke(Request $request): Response
    {
        $filters = $request->query->all();
        return new Response(
            $this->template->render(
                'bookList.html.twig',
                [
                    'books' => $this->booksProvider->fetchBooksByFilter($filters),
                ]
            )
        );
    }
}
