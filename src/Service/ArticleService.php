<?php

namespace Peg\Service;

use Peg\System\Http\Request;

class ArticleService
{
    public function getArticles()
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