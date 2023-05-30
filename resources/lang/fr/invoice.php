<?php

return array(
    "Invoice" => "Facture",
    "Addressed to" => "Adressé à",
    "sender_address" => <<<boxify
<strong>Boxify SPRL</strong><br />
Avenue Louise 54<br />
1050 Bruxelles<br />
Email : payment@boxify.be
boxify
    ,
    'Order n°' => 'Facture n°',
    'Invoiced by' => 'Facturé par',
    'date' => 'Date',
    'total' => 'Total',
    'Description' => 'Description',
    'Price' => 'Prix',
    'Tax' => 'TVA 21%',
    'Total VAT Excl.' => 'Total TVA Excl.',
    "description" => [
        'prorate' => "Abonnement pour {item.name} n° {item.id} ({date.begin} - {date.end})",
        'get-back' => "Demande de retour",
        'subscription' => "Abonnement mensuel ({date.begin} - {date.end})",
        'addon' => '- {item.name} n° {item.id}',
        'fee' => 'Amende : {fee.name} n° {fee.id}',
        'end' => 'Frais de fin de subscription',
    ],
    'footer' => 'ING BE55 3631 5334 7744 - TVA BE0640 926 411 - RPM Bruxelles',
    "- 2% majoration by credit card" => "- 2% majoration by credit card"
);
