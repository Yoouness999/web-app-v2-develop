<?php

return array(
    "Invoice" => "Invoice",
    "Addressed to" => "Addressed to",
    "sender_address" => <<<boxify
<strong>Boxify SPRL</strong><br />
Louise Avenue 54<br />
1050 Brussels<br />
Email : payment@boxify.be
boxify
    ,
    'Order n°' => 'Invoice n°',
    'Invoiced by' => 'Invoiced by',
    'date' => 'Date',
    'total' => 'Total',
    'Description' => 'Description',
    'Price' => 'Price',
    'Tax' => 'VAT 21%',
    'Total VAT Excl.' => 'Total VAT Excl.',
    "description" => [
        'prorate' => "Subscription prorata for {item.name} n° {item.id} ({date.begin} - {date.end})",
        'get-back' => "Demande de retour",
        'order' => "Order prorata ({date.begin} - {date.end})",
        'subscription' => "Monthly Subscription ({date.begin} - {date.end})",
        'addon' => '- {item.name} n° {item.id}',
        'fee' => 'Fee : "{fee.name}" n° {fee.id}',
        'end' => "End Subscription fee ({date.begin} - {date.end})",
    ],
    'footer' => 'ING BE55 3631 5334 7744 - VAT BE0640 926 411 - RPM Brussels',
    "- 2% majoration by credit card" => "- 2% majoration by credit card"
);
