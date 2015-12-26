<?php

/**
 * Конфиг для Doctrine DBAL
 * можно подключать любую базу, которую он поддерживает
 * @link     http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html
 */

return [
    'db' => [
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/db.sqlite'
    ]
];