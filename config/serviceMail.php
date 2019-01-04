<?php

use Framework\MailHelper;
use function \DI\object as di_object;

return [
  MailHelper::class => di_object(MailHelper::class)
];