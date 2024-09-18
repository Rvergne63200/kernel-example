<?php 

namespace Peg\Controller;

use Peg\Service\ArticleService;
use Peg\System\Http\JsonResponse;

class ArticleController extends AbstractController
{
    public function __construct(
        protected ArticleService $articleService
    ){}

    public function list() : JsonResponse
    {
        return new JsonResponse($this->articleService->getArticles());
    }
}