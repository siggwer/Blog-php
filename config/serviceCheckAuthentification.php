<?php

use Framework\CheckAuthAdmin;
use Framework\CheckAuthUser;

use function \DI\object as di_object;

return[

    CheckAuthAdmin::class=>di_object(CheckAuthAdmin::class),
    CheckAuthUser::class=>di_object(CheckAuthUser::class)
];
