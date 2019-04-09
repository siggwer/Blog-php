<?php


namespace Framework;

use GuzzleHttp\Psr7\Response;

class CheckAuthUser
{
    use GetField, Flash;

    /**
     * @return Response
     */
    public function CheckAuthentification()
    {
        $session = $_SESSION['auth'];
        if (!array_key_exists('auth', $session)) {
            if (empty($_SESSION['auth'])) {
                $this->setFlash(
                    'warning',
                    'Vous devez être connecté pour accéder à votre espace'
                );
                return new Response(
                    301,
                    [
                        'Location' => '/login'
                    ]
                );
            }
        }
        if(array_key_exists('auth', $session)
            && $session->getRank() === 3)
        {
            return new Response(
                301,
                [
                    'Location' => '/adminaccount'
                ]
            );
        }
    }
}