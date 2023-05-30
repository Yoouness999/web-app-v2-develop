<?php
return [
    'menu' => [
        [
            'name'     => 'Gérer',
            'link'     => action('Profile\ProfileController@anyManage'),
            'active'   => Request::is('profile/manage'),
        ],
        [
            'name'     => 'Commander',
            'link'     => url('order'),
            'active'   => Request::is('order'),
        ],
        [
            'name'     => 'Compte',
            'link'     => action('Profile\ProfileController@getAccount'),
            'active'   => Request::is('profile/account'),
        ],
        [
            'name'     => 'Parrainage',
            'link'     => action('Profile\ProfileController@getSponsorship'),
            'active'   => Request::is('profile/sponsorship'),
        ],
    ],

    'user' => [
        [
            'name' => 'Uitloggen',
            'link' => '/auth/logout',
            'active' => false,
        ],
    ],
];