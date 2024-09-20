<?php

namespace Peg\Controller;

use Peg\Service\ArticleServiceInterface;
use Peg\System\Http\JsonResponse;

class ArticleController extends AbstractController
{
    public function __construct(
        protected ArticleServiceInterface $articleService
    ) {}

    public function list(): JsonResponse
    {
        return new JsonResponse($this->articleService->getArticles());
    }
}
