<?php

/**
 * Navbar menu
 */
return array(
    'navbar' => [[
        [
            'name' => 'Dienst',
            'link' => '/page/service',
            'active' => false,
        ], [
            'name' => 'Prijs',
            'link' => '/page/pricing',
            'active' => false,
        ], /*[
            'name' => 'Professioneel',
            'link' => '/page/business',
            'active' => false,
        ],*/ [
            'name' => 'Contact',
            'link' => '/page/contact',
            'active' => false,
        ]],

        [[
            'name' => 'Blog',
            'link' => '/blog',
            'active' => false,
        ], [
            'name' => 'Storage rules',
            'link' => '/page/storage-rules',
            'active' => false,
        ], [
            'name' => 'F.A.Q',
            'link' => '/page/faq',
            'active' => false,
        ], [
            'name' => 'About',
            'link' => '/page/about',
            'active' => false,
        ]
    ], [[
        'name' => 'Terms of use',
        'link' => '/page/terms',
        'target' => '_blank',
        'active' => false,
    ]]],

    'user' => [
        [
            'name' => 'Mijn spullen opslaan',
            'link'     => '/order',
            'active' => false,
        ],
        [
            'name' => 'Manager',
            'link'     => '/profile/manage',
            'active' => false,
        ],
        [
            'name' => 'Mijn account',
            'link'     => '/profile/account',
            'active' => false,
        ],
        [
            'name' => 'Uitloggen',
            'link' => '/auth/logout',
            'active' => false,
        ]
    ]
);
