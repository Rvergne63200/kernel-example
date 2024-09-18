<?php

namespace Peg\System\Http;

class JsonResponse extends Response
{
    public function __construct(protected mixed $data, array $headers = []) {
        $headers = array_merge([
            'Content-Type' => 'application/json; charset=utf-8'
        ], $headers);
        
        parent::__construct(json_encode($data), $headers);
    }
}