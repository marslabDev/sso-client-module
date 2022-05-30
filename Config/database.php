<?php

return [
    'driver' => 'mysql',
    'url' => env('SSO_DATABASE_URL'),
    'host' => env('SSO_DB_HOST', '192.168.1.134'),
    'port' => env('SSO_DB_PORT', '3306'),
    'database' => env('SSO_DB_DATABASE', 'vrdrum_sso'),
    'username' => env('SSO_DB_USERNAME', 'marslab'),
    'password' => env('SSO_DB_PASSWORD', '@Marslab111'),
    'unix_socket' => env('SSO_DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
];
