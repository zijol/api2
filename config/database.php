<?php

use App\Services\Helper\Encryption;

$config = [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'irt'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        // ADMIN
        'admin' => [
            'driver' => 'mysql',
            'host' => env('ADMIN_DB_HOST', '127.0.0.1'),
            'port' => env('ADMIN_DB_PORT', '3306'),
            'database' => env('ADMIN_DB_NAME', 'admin'),
            'username' => env('ADMIN_DB_USER', 'root'),
            'password' => env('ADMIN_DB_PWD', '123456'),
            'unix_socket' => env('ADMIN_DB_SOCKET', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ],

        // ADMIN
        'irt' => [
            'driver' => 'mysql',
            'host' => env('ADMIN_DB_HOST', '127.0.0.1'),
            'port' => env('ADMIN_DB_PORT', '3306'),
            'database' => env('ADMIN_DB_NAME', 'IRT'),
            'username' => env('ADMIN_DB_USER', 'root'),
            'password' => env('ADMIN_DB_PWD', '123456'),
            'unix_socket' => env('ADMIN_DB_SOCKET', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],

];

// 对于数据库连接密码进行解密操作
foreach ($config['connections'] as $connection => &$db) {
    if (isset($db['password']) && strlen($db['password']) > 40) {
        $db['password'] = Encryption::decryptPassword($db['password'], env('API_ENCRYPTION_KEY'), true);
    }
}

return $config;
