<?php
return array(
	"meta" => [
		"metatitle" => "Contactez-nous | Boxify",
		"metadescription" => "Informations de contact Boxify & Service clientèle. Avenue Louise 54 1050 Bruxelles. +32 2 318 59 16",
		"subtitle" => "",
		"googletag" => "",
		"banner" => "",
	],
    "title" => "Contactez-nous",
    'subtitle' => '',
    "content_left" => <<<content
<h3>Adresse</h3>
<p>
   Boxify HQ <br>
Avenue Louise 54 <br/>
1050 Bruxelles <br/>

</p>

<h3>Service clientèle</h3>
<p>
Lundi – Dimanche : 8h – 20h<br>
</p>

<a href="mailto:support@boxify.be">support@boxify.be</a>

<h3>Relation presse & media</h3>
<a href="mailto:press@boxify.be">press@boxify.be</a>
content
, "form" => [
        'subjects' => [
                'customer' => ['title' => 'Service client', 'email' => 'support@boxify.be'],
                'technical' => ['title' => 'Service technique', 'email' => 'support@boxify.be'],
                'business' => ['title' => 'Service commercial', 'email' => 'support@boxify.be'],
                'press' => ['title' => 'Presse', 'email' => 'press@boxify.be'],
                'information' => ['title' => 'Information', 'email' => 'info@boxify.be'],
                'job' => ['title' => 'Job', 'email' => 'jobs@boxify.be'],
        ]
    ]
);
