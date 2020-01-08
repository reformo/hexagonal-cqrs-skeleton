<?php
declare(strict_types=1);

return [
    'mezzio-swoole' => [
        'swoole-http-server' => [
            'port' => 8081,
            'options' => [
                'pid_file' => sys_get_temp_dir() . '/zend-swoole-private-api.pid'
            ]
        ]
    ]
];