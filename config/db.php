<?php

// Data Base configuration
use function \DI\get as di_get;
use function \DI\env as di_env;
use function \DI\string as di_string;
use function \DI\object as di_object;

use App\Pdo\Interfaces\PdoDatabaseInterface;
use App\Pdo\PdoDatabase;

return [
    'db.type' => di_env('db_type', 'mysql'),
    'db.host' => di_env('db_user', 'localhost'),
    'db.name' => di_env('db_name', 'blog'),
    'db.port' => di_env('db_port', 3306),

    'db.dsn' => di_string('{db.type}:host={db.host};dbname={db.name};port={db.port};charset=utf8'),
    'db.user' => di_env('db_user', 'root'),
    'db.pass' => di_env('db_pass', ''),
    'db.options' => [],

    PdoDatabaseInterface::class => di_object(PdoDatabase::class)->constructor(
        di_get('db.dsn'),
        di_get('db.user'),
        di_get('db.pass'),
        di_get('db.options')
    )
];