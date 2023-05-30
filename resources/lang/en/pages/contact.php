<?php

return array(
    "meta" => [
        "metatitle" => "Contact us | Boxify",
        "metadescription" => "Contact information & Customer support inquiries. Avenue Louise 54 1050 Bruxelles. +32 2 318 59 16",
        "subtitle" => "",
        "googletag" => "",
        "banner" => "",
    ],
    "title" => "Contact us",
    'subtitle' => '',
    "content_left" => <<<content
<h3>Address</h3>
<p>
   Boxify HQ <br>
Avenue Louise 54 <br/>
1050 Brussels <br/>
</p>

<h3>Customer support inquiries</h3>
<p>
    Monday – Sunday : 8 AM – 8PM
</p>
<a href="mailto:support@boxify.be">support@boxify.be</a>

<h3>Press & Media inquiries</h3>
<a href="mailto:press@boxify.be">press@boxify.be</a>
content
, "form" => [
        'subjects' => [
            'customer' => ['title' => 'Customer support', 'email' => 'support@boxify.be'],
            'technical' => ['title' => 'Technical support', 'email' => 'support@boxify.be'],
            'business' => ['title' => 'Commercial support', 'email' => 'support@boxify.be'],
            'press' => ['title' => 'Press', 'email' => 'press@boxify.be'],
            'information' => ['title' => 'Information', 'email' => 'info@boxify.be'],
            'job' => ['title' => 'Job', 'email' => 'jobs@boxify.be']
        ]
    ]
);
