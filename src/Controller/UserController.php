<?php

namespace Peg\Controller;

use Peg\Service\UserService;
use Peg\System\Http\JsonResponse;
use Peg\System\Http\Response;

class UserController extends AbstractController
{
    public function __construct(
        protected UserService $userService,
    ){}

    public function list() : JsonResponse
    {
        return new JsonResponse($this->userService->getUsers());
    }
}