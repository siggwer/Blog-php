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

    'sendgrid.api.key' => di_string('SENDGRID_APY_KEY'),

    MailHelper::class => di_object(MailHelper::class)->constructor(
        di_get('sendgrid.api.key')
    )
];
