<?php

namespace Peg\Service;

class ArticleService implements ArticleServiceInterface
{
    public function getArticles(): array
    {
        return [
            [
                'title' => 'Le bois de Flamanville',
                'description' => 'Article qui traite du bois de Flamanville et de ses allentours'
            ],
            [
                'title' => 'La cascade de Loria',
                'description' => 'La cascade de Loria est un très bel endroit pour se promener'
            ]
        ];
    }
}
