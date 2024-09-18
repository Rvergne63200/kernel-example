<?php

namespace Peg\System\Http;

class Response 
{
    protected array $headers;

    public function __construct(protected string $response, array $headers = []){
        $this->headers = array_merge([
            'Content-Type' => 'text/html; charset=utf-8'
        ], $headers);
    }

    public function render()
    {                
        foreach($this->headers as $key => $header){
            header($key . ': ' . $header);
        }
    
        echo $this->response;
        exit();
    }
}