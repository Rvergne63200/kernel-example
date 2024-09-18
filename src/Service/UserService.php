<?php

namespace Peg\Service;

class UserService
{
    public function __construct(
        private int $max
    ){}

    public function getUsers() : array
    {
        return array_slice([
            "Jean",
            "Luc",
            "Marie",
            "Martin",
            "Thomas",
            "Léonce"
        ], 0, $this->max);
    }
}