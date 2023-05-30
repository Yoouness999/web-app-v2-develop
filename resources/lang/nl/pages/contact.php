<?php
return array(
	"meta" => [
		"metatitle" => "Neem contact met ons op | Boxify",
		"metadescription" => "Contactgegevens Boxify en klantendienst. Louizalaan 54 1050 Brussel. +32 2 318 59 16",
		"subtitle" => "",
		"googletag" => "",
		"banner" => "",
	],
    "title" => "Neem contact met ons op",
    'subtitle' => '',
    "content_left" => <<<content
<h3>Adres</h3>
<p>
   Boxify HQ <br>
Louizalaan 54 <br/>
1050 Brussel <br/>

</p>

<h3>Klantenservice</h3>
<p>
Maandag – Zondag : 8 – 20u<br>
</p>

<a href="mailto:support@boxify.be">support@boxify.be</a>

<h3>Pers- & mediarelaties</h3>
<a href="mailto:press@boxify.be">press@boxify.be</a>
content
, "form" => [
        'subjects' => [
                'customer' => ['title' => 'Klantenservice', 'email' => 'support@boxify.be'],
                'technical' => ['title' => 'Technische dienst', 'email' => 'support@boxify.be'],
                'business' => ['title' => 'Commerciële dienst', 'email' => 'support@boxify.be'],
                'press' => ['title' => 'Pers', 'email' => 'press@boxify.be'],
                'information' => ['title' => 'Informatie', 'email' => 'info@boxify.be'],
                'job' => ['title' => 'Jobs', 'email' => 'jobs@boxify.be'],
        ]
    ]
);
