<?php


/**
 * Navbar menu
 */
return array(
    'navbar' => [[
        [
            'name' => 'Service',
            'link' => '/page/service',
            'active' => false,
        ], [
            'name' => 'Pricing',
            'link' => '/page/pricing',
            'active' => false,
        ], [
            'name' => 'Professionnal',
            'link' => '/page/business',
            'active' => false,
        ], [
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
            'name'     => 'Schedule',
            'link'     => '/order',
            'active'   => false,
        ],
        [
            'name'     => 'Manager',
            'link'     => '/profile/manage',
            'active'   => false,
        ],
        [
            'name'     => 'Account',
            'link'     => '/profile/account',
            'active'   => false,
        ],
        [
            'name' => 'Logout',
            'link' => '/auth/logout',
            'active' => false,
        ]
    ]
); 
