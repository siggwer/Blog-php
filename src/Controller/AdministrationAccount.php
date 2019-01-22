<?php

namespace App\Controller;

use App\Service\Users;
use DI\Container;
use Framework\Interfaces\RenderInterfaces;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
//use Framework\GetField;
//use Framework\Flash;

class AdministrationAccount
{
    //use GetField, Flash;
    /**
     * @var
     */
    private $users;

    /**
     * AdministrationAccount constructor.
     *
     * @param Users $user
     */
    public function __construct(Users $user) {
        $this->users = $user;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Container $container
     *
     * @return ResponseInterface
     *
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {

        var_dump($_SESSION['auth']);
        exit;

    }
}