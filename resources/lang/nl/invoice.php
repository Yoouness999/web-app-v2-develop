<?php

return array(
    "Invoice" => "Factuur",
    "Addressed to" => "Bestemd voor",
    "sender_address" => <<<boxify
<strong>Boxify BVBA</strong><br />
Louizalaan 54<br />
1050 Brussel<br />
Email : payment@boxify.be
boxify
    ,
    'Order n°' => 'Factuur n°',
    'Invoiced by' => 'Gefactureerd door',
    'date' => 'Datum',
    'total' => 'Total',
    'Description' => 'Omschrijving',
    'Price' => 'Prijs',
    'Tax' => 'BTW 21%',
    'Total VAT Excl.' => 'Totaal BTW Excl.',
    "description" => [
        'prorate' => "Abonnement voor {item.name} n° {item.id} ({date.begin} - {date.end})",
        'subscription' => "Maandelijks abonnement ({date.begin} - {date.end})",
        'addon' => '- {item.name} n° {item.id}',
        'fee' => 'Boete : {fee.name} n° {fee.id}',
        'end' => 'Stopzettingskosten inschrijving',
    ],
    'footer' => 'ING BE55 3631 5334 7744 - BTW BE0640 926 411 - RPR Brussel',
    "- 2% majoration by credit card" => "- 2% majoration by credit card"
);
