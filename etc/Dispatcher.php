<?php


namespace Framework;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Dispatcher
{
    /**
     * @var array $middlewares
     */
    private $middlewares;

    /**
     * @var Container $container
     */
    private $container;

    /**
     * @var int
     */
    private $indexMiddleware;

    /**
     * Dispatcher constructor.
     *
     * @param Container $container
     * @param array     $middlewares
     */
    public function __construct(Container $container,
        array $middlewares = []
    ) {
        $this->container = $container;
        $this->indexMiddleware = 0;

        foreach($middlewares as $middleware) {
            $this->pipe($middleware);
        }
    }

    /**
     * @param string $middleware
     */
    public function pipe(string $middleware)
    {
        try {
            $this->middlewares[] = $this->container->get($middleware);
        } catch (DependencyException $e) {
        } catch (NotFoundException $e) {
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $middleware = $this->getMiddleware();
        $this->indexMiddleware += 1;

        if(is_null($middleware)) {
            return $response;
        }

        return $middleware(
            $request, $response, $this->container, [$this, 'process']
        );
    }

    /**
     * @return mixed|null
     */
    private function getMiddleware()
    {
        return $this->middlewares[$this->indexMiddleware] ?? null;
    }
}
