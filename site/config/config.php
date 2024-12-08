<?php

return [
    'debug' => true,
    'panel' => [
        'install' => true
    ],
    'api' => [
        'basicAuth' => true
    ],
    'languages' => true,
    'users' => [
        'defaultRole' => 'editor'
    ],
    'thumbs' => [
        'srcsets' => [
            'default' => [300, 600, 900, 1200, 1800, 2400, 3000, 3600, 4200, 4800],
            'large' => [300, 600, 900, 1200, 1800, 2400, 3000, 3600, 4200, 4800],
            'medium' => [300, 600, 900, 1200, 1800, 2400, 3000, 3600, 4200, 4800],
            'small' => [300, 600, 900, 1200, 1800, 2400, 3000, 3600, 4200, 4800],
            'tiny' => [300, 600, 900, 1200, 1800, 2400, 3000, 3600, 4200, 4800],
        ]
    ],
    'routes' => [
        [
            'pattern' => 'artists',
            'action'  => function () {
                return go('/');
            }
        ],
        [
            'pattern' => '(:any)',
            'action'  => function ($uri) {
                $page = page($uri);
                if (!$page) $page = page('error');
                return site()->visit($page);
            }
        ],
    ],

];
