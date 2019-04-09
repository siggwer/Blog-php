<?php


namespace Framework;

use GuzzleHttp\Psr7\Response;

class CheckAuthAdmin
{
    use GetField, Flash;

    /**
     * @return Response
     */
    public function checkAuthentification()
    {
        if (!array_key_exists('auth', $_SESSION)) {
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


        if (array_key_exists('auth', $_SESSION)
            && $_SESSION['auth']->getRank() === 3
        ) {
            $this->setFlash('success', 'Vous êtes connecté!');
            return new Response(
                301,
                [
                    'Location' => '/adminaccount'
                ]
            );
        }

        if (array_key_exists('auth', $_SESSION)
            && $_SESSION['auth']->getRank() < 3
        ) {
            $this->setFlash('warning', 'Vous ne pouvez pas accéder à cette espace!');
        }
        return new Response(
            301,
            [
                'Location' => '/'
            ]
        );
    }
}
