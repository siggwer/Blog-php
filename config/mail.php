<?php

use function \DI\get as di_get;
use function \DI\object as di_object;
use function \DI\string as di_string;
use Framework\MailHelper;

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

    'sendgrid.api.key' => di_string('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'),

    MailHelper::class => di_object(MailHelper::class)->constructor(
        di_get('sendgrid.api.key')
    )
];

//SENGRID_APIKEY