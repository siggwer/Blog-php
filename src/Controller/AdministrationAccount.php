<?php

namespace App\Controller;

use App\Model\User;
use App\Service\Users;
use DI\Container;
use Framework\Interfaces\RenderInterfaces;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\GetField;
use Framework\Flash;

class AdministrationAccount
{
    use GetField, Flash;
    /**
     * @var
     */
    private $user;

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
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Container $container) {

        //$user = $this->user->getRank($rankAdmin = 2);

        $user = $this->users->allArticlesByPseudo($request->getAttribute('pseudo', 0));

        if ($request->getMethod() === 'GET') {
            $view = $container->get(RenderInterfaces::class)->render('administration', ['user' => $user]);
            $response->getBody()->write($view);
            return $response;
        }

        $usersId = $this->getField('user_id');
        $user = $this->user->getUserById($usersId);

        if ($user) {
            $users['rank'] = 1;
            $this->user->updateUser($users);

            $this->setFlash('success', 'L\'utilisateur n\'est plus admin');
        } else {
            $this->setFlash('warning', 'Un problème est survenue');
        }
        return new Response(301, [
            'Location' => '/account'
        ]);
    }
}