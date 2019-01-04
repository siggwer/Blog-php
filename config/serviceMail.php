<?php

use Framework\MailHelper;
use function \DI\string as di_string;

return [
  MailHelper::class => di_string(MailHelper::class)
];