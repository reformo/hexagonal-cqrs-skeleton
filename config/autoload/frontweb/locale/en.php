<?php
declare(strict_types=1);

return [
    'domain' => 'FrontWeb',
    'locale' => 'en_US',
    'plural-forms' => 'nplurals=3; plural=(n % 10 == 1 && n % 100 != 11) ? 0 : ((n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 12 || n % 100 > 14)) ? 1 : 2);',
    'messages' => [
        'HOME_PAGE_WELCOME_TO_S' => [
            'translate' => 'Welcome to %s',
            'reference' => 'Infrastructure/Ui/FormWeb/templates/app/home-page.html.twig',
            'comment' => 'Hero Welcome Message'
        ],
        'NUMBER_OF_USERS' => [
            'translate' => 'One user',
            'translate-plural' => '%s users',
            'reference' => 'Infrastructure/Ui/FormWeb/templates/app/home-page.html.twig',
            'comment' => 'Number of users'
        ],
        'NO_USERS' => [
            'translate' => 'No user atm.',
            'reference' => 'Infrastructure/Ui/FormWeb/templates/app/home-page.html.twig',
            'comment' => 'Number of users'
        ],
        'USER_LIST_HEADER' => [
            'translate' => 'User List',
            'reference' => 'Infrastructure/Ui/FormWeb/templates/app/home-page.html.twig',
        ],
    ]
];