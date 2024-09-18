<?php

namespace Peg\System\Http;

class Request
{
    private $request;

    public function __construct()
    {
        $this->request = $_REQUEST;
    }

    public function get(mixed $key)
    {
        if(array_key_exists($key, $this->request)){
            return $this->request[$key];
        }

        return null;
    }
}