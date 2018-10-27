<?php
declare(strict_types=1);

namespace CWStorage;

use Psr\Http\Message\ResponseInterface;

class Application
{
    private $response;

    public function __construct(
        ResponseInterface $response
    ) {
        $this->response = $response;
    }

    public function __invoke(): ResponseInterface
    {
        // TODO: JsonResponse
        $response = $this->response->withHeader('Content-Type', 'application/json');

        $response->getBody()
            ->write('{"status": "ok", "message": "Hello!"}');

        return $response;
    }
}