<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Remote Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default connection that will be used for SSH
    | operations. This name should correspond to a connection name below
    | in the server list. Each connection will be manually accessible.
    |
    */
    'default'     => 'production',
    /*
    |--------------------------------------------------------------------------
    | Remote Server Connections
    |--------------------------------------------------------------------------
    |
    | These are the servers that will be accessible via the SSH task runner
    | facilities of Laravel. This feature radically simplifies executing
    | tasks on your servers, such as deploying out these applications.
    |
    */
    'connections' => [
        'production' => [
            'host'      => 'boxify.be',
            'username'  => 'root',
            'password'  => '',
            'key'       => '',
            'keytext'   => '-----BEGIN RSA PRIVATE KEY-----
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
-----END RSA PRIVATE KEY-----',
            'keyphrase' => '',
            'agent'     => '',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Remote Server Groups
    |--------------------------------------------------------------------------
    |
    | Here you may list connections under a single group name, which allows
    | you to easily access all of the servers at once using a short name
    | that is extremely easy to remember, such as "web" or "database".
    |
    */
    'groups'      => [
        'web' => [ 'production' ]
    ],
];
