<?php

return [
    'debug' => false,
    'panel' => [
        'install' => false
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
            'pattern' => 'program',
            'action'  => function () {
                $launchDate = new DateTime('2025-02-26 18:00:00', new DateTimeZone('Australia/Perth'));
                $now = new DateTime('now', new DateTimeZone('Australia/Perth'));

                if ($now < $launchDate) {
                    // check user
                    if (kirby()->user()) {
                        return page('program');
                    }
                    // if no user, redirect
                    return go('/program/program-launch');
                }

                return page('program');
            }
        ],
        // [
        //     'pattern' => 'tickets',
        //     'action'  => function () {

        //         return go('https://events.humanitix.com/audible-edge-25/tickets');
        //     }
        // ],
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
