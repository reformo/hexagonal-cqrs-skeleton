<?php
declare(strict_types=1);

return [
    'zend-expressive-swoole' => [
        'swoole-http-server' => [
            'port' => 8080,
            'options' => [
                'pid_file' => sys_get_temp_dir() . '/zend-swoole-front-web.pid'
            ],
            'static-files' => [
                'enable' => true,
                'document-root' => 'src/Infrastructure/Ui/Frontweb/public',
            ],
        ]
    ]
];