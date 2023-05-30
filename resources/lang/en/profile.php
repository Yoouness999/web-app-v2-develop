<?php
return [
    'menu' => [
        [
            'name'     => 'Manage',
            'link'     => action('Profile\ProfileController@anyManage'),
            'active'   => Request::is('profile/manage'),
        ],
        [
            'name'     => 'Order',
            'link'     => url('order'),
            'active'   => Request::is('order'),
        ],
        [
            'name'     => 'Account',
            'link'     => action('Profile\ProfileController@getAccount'),
            'active'   => Request::is('profile/account'),
        ],
        [
            'name'     => 'Sponsorship',
            'link'     => action('Profile\ProfileController@getSponsorship'),
            'active'   => Request::is('profile/sponsorship'),
        ],
    ],

    'user' => [
        [
            'name' => 'Logout',
            'link' => '/auth/logout',
            'active' => false,
        ],
    ],
];
