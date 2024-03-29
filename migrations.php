<?php

use app\core\Application;

require_once  __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('Europe/Amsterdam');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'pass' => $_ENV['DB_PASS']
    ],
    'smtp' => [
        'host' => $_ENV['SMTP_HOST'],
        'user' => $_ENV['SMTP_USER'],
        'pass' => $_ENV['SMTP_PASS']
    ],
    'mollie' => [
        'api_key' => $_ENV['MOLLIE_API_KEY']
    ]
];

$app = new Application(__DIR__, $config);

$app->db->applyMigrations();