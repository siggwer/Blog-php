<?php

use function \DI\object as di_object;

use Framework\MailHelper;

return [
    MailHelper::class => di_object(MailHelper::class),
];
