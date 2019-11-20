<?php
declare(strict_types=1);

return [
    'http' => [
        'response' => [
            'custom-headers' => [
                'X-XSS-Protection' => '1',
                'Content-Security-Policy' => 'default-src \'self\'',
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'sameorigin',
                'Strict-Transport-Security' => 'max-age=63072000'
            ]
        ]
    ]
];