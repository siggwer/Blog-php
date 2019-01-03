<?php

use function \DI\string as di_string;

// Mail configuration
//return[
    //'from' => 'your@from',
    //'to' => 'your@email.fr',
    //'smtp' => 'your@smtp',
    //'port' => 'your@port',
    //'userName' => 'your@userName',
    //'password' => 'your@password'
//];

return[

    'api.key' => di_string('SENGRID_APIKEY')
];
