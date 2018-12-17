<?php

namespace App\Controller;

use App\Model\Users;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Framework\GetFiled;
use Framework\Flash;
use Framework\Interfaces\RenderInterfaces;
class AdministrationController
{
    use GetFiled, Flash;

    /**
     * @var $user
     */
    private $user;

    /**
     * AdministrationController constructor.
     * @param Users $user
     */
    public function  __construct(Users $user)
    {
        $this->user = $user;
    }

    /**
     * @param ServerRequestInterface $request
     * @param Response $response
     * @param Container $container
     * @return Response
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __invoke(ServerRequestInterface $request, Response $response, Container $container)
    {

        $users = $this->user->getRank($rankAdmin = 2);
        if ($request->getMethod() === 'GET') {
            $view = $container->get(RenderInterfaces::class)->render('administration', ['users' => $users]);
            $response->getBody()->write($view);
            return $response;
        }

        $usersId = $this->getField('users_id');
        $users = $this->user->getUserById($usersId);

        if ($users) {
            $users['rank'] = 1;
            $this->user->updateUser($users);

            $this->setFlash('success', 'L\'utilisateur n\'est plus admin');
        } else {
            $this->setFlash('warning', 'Un problème est survenue');
        }
        return new Response(301, [
            'Location' => '/panel/users/admin'
        ]);
    }
}