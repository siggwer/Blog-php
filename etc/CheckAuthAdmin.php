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
        $session = $_SESSION['auth'];

        if (!array_key_exists('auth', $session)
        ) {
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

        if (array_key_exists('auth',$session)
        && $session->getRank() < 3
        ) {
            $this->setFlash("danger", "Vous devez être admin pour entrer");
            return new Response(
                301,
                [
                    'Location' => '/account'
                ]
            );
        }
    }
}
