<?php

namespace App\Controller;

use App\Service\Users;
use DI\Container;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\GetField;
use Framework\Flash;
use Framework\Token;
use Framework\Interfaces\RenderInterfaces;

class LoginController
{
    use Token, Flash, GetField;

    /**
     * @var Users
     */
    private $userServices;

    /**
     * LoginController constructor.
     *
     * @param Users $userServices
     */
    public function __construct(Users $userServices)
    {
        $this->userServices = $userServices;
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
        if ($request->getMethod() === 'GET') {
        $view = $container->get(RenderInterfaces::class)->render('login');
        $response->getBody()->write($view);
        return $response;
    }

        $pseudo = $this->getField('pseudo');
        $password = $this->getField('password');
        $remember = $this->getField('remember-me');


        $user = $this->userServices->getUserByPseudo($pseudo);
        var_dump($user);

        //$_SESSION['auth'] = $user;

        if (array_key_exists('auth', $_SESSION)){
            if (!empty($_SESSION['auth']) && $_SESSION['auth']->getPseudo() === $pseudo) {
                //&& $_SESSION['auth']->pseudo() === $pseudo
                $this->setFlash('warning', 'Vous êtes déjà connecté !');
                return new Response(301, [
                    'Location' => '/account'
                ]);
            }
        }

        if ($user && password_verify($password, $user->getPassword())) {
        //$pseudo . '#-$' . $password
            //&& $user->getEmail_token() === null
            if (!empty($remember)) {
                $token = $this->generateToken();
                setcookie('remember-me', $token, time() + 3600 * 24 * 7, '/', null, false, true);
            }

            $_SESSION['auth'] = $user;

            $this->setFlash('success', 'Vous êtes maintenant connecté !');
            return new Response(301, [
                'Location' => '/account'
            ]);
        }
        var_dump($pseudo);
        exit;
        $this->setFlash('danger', 'Mauvais mot de passe ou pseudo');
        return new Response(301, [
            'Location' => '/login'
        ]);
    }
}