<?php

return [
    'title' => 'Manager',

    'card' => [
        'drop' => 'We will drop',
        'drop_back' => 'We will drop back',
        'no_picture' => 'No photo',
        'pickup_date' => 'Scheduled on',
        'storage_date' => 'Stored on',
    ],

    'filters' => [
        'search' => 'Search',
        'sort_by' => 'Sort by',
        'sorting' => [
            '-storage_date' => 'Date ↑',
            '+storage_date' => 'Date ↓',
            '+description' => 'Name ↓',
            '-description' => 'Name ↑',
        ],
        'types' => [
            'in_transit' => 'In transit',
            'in_storage' => 'In storage',
            'with_me' => 'With me',
        ],
    ],

    'form' => [
        'reschedule' => 'Reschedule',
        'want_back' => 'I want it back',
        'address' => 'Enter your full address',
        'number' => 'Number',
        'box' => 'Box',
        'postalcode' => 'Postal code',
        'city' => 'City',
        'delivery_instructions' => 'Additional delivery instructions',
        'available_date' => 'Please select an available date',
        'wait-fill-boxes' => 'Attendre 20 minutes le temps de remplir les boites',
        'button_reschedule' => 'Reschedule',
        'button_get_back' => 'Get it back',
        'button_cancel' => 'Cancel',
        'thank_you' => 'Thank you',
    ],

    'insurances' => [
        'base' => 'Base',
        'normal' => '1000€',
        'medium' => '2500€',
        'on_demand' => '+2500€',
    ],

    'items' => [
        'no_items' => 'You don\'t have any items',

        'tabs' => [
            'in_storage' => 'Items in storage',
            'in_transit' => 'Items in transit',
            'with_me' => 'Items with me',
        ],

        'title' => [
            'in_storage' => 'Select to get back',
            'in_transit' => 'Select for schedule',
            'with_me' => 'Items with me',
        ],
        'has_selection' => [
            'in_storage' => 'I want this item back !',
            'in_transit' => 'Reschedule',
        ],
    ],

    'modals' => [
        'cancel' => 'Cancel',
        'insurance' => 'Voulez vraiment modifier le montant de l\'assurance ?',
        'storing_duration' => 'Voulez vraiment modifier la durée d\'engagement ?',
        'ok' => 'Confirm',
    ],

    'plans' => [
        'item' => 'Boxes',
        '3m3' => '3m3',
        '5m3' => '5m3',
        '7m3' => '7m3',
        '9m3' => '9m3',
        '11m3' => '11m3',
        '13m3' => '13m3',
        '16m3' => '16m3',
        '20m3' => '20m3',
        '25m3' => '25m3',
        '30m3' => '30m3',
        '>30m3' => '>30m3',
    ],

    'resume' => [
        'plan' => 'Your plan',
        'engagement' => 'Engagement',
        'insurance' => 'Insurance',
        'price' => '{{price}} €/maand',
    ],

    'storing_durations' => [
        '-6_months' => '-6 mois',
        '6_months' => '> 6 mois',
        '12_months' => '> 12 mois',
    ],

    'times' => [
        '08:00' => '08:00 - 10:00',
        '10:00' => '10:00 - 12:00',
        '12:00' => '12:00 - 14:00',
        '14:00' => '14:00 - 16:00',
        '16:00' => '16:00 - 18:00',
        '18:00' => '18:00 - 20:00',
    ],

    'services' => [
        'title' => 'Let’s get some details',
        'submit' => 'Continue to appointment',
        'economy' => 'Si vous descendiez tous vos biens au rez de chaussée, le prix serait de',
        'questions' => [
            'carriers' => 'Avez-vous des biens qui nécessitent deux personnes pour être transportés ? <em>(Si vous aidez le livreur et que vos biens sont au RDC, sélectionnez NON)</em>',
            'floors_without_carriers_lte_6m3' => 'A quel étage se trouvent les biens ?',
            'floors_without_carriers_gt_6m3' => 'A quel étage se trouvent les biens ?',
            'fragile_without_carriers' => 'Avez-vous des biens qui cassent facilement et qui auraient besoin de traitement sépcial ?',
            'parking_without_carriers' => 'Vous occupez-vous de réserver une zone de stationnement pour notre camion ?',
            'floors_with_carriers' => 'A quel étage se trouvent les biens ?',
            'handling' => 'Avez-vous des biens qui nécessitent de la manutention supplémentaire ? <em>(Faut-il plus de 2 personnes pour porter les biens?)</em>',
            'fragile_with_carriers' => 'Avez-vous des biens qui cassent facilement et qui auraient besoin de traitement sépcial ?',
            'parking_with_carriers' => 'Vous occupez-vous de réserver une zone de stationnement pour notre camion ?',
        ],
        'answers' => [
            'yes' => 'Yes',
            'no' => 'No',
        ],

        'resume' => [
            'title' => 'Pickup Services',
        ],

        'buttons' => [
            'change_answers' => 'Change answers',
            'submit_answers' => 'Update answers',
        ],

        'with_carriers' => 'With carriers',
        'with_carriers_floors_=0' => 'RDC',
        'with_carriers_floors_>=1' => 'Floor ≥ 1',
        'with_carriers_floors_>=4' => 'Floor ≥ 4',
        'with_carriers_floors_>=8' => 'Floor ≥ 8',
        'with_carriers_fragile' => 'Fragile',
        'with_carriers_not_fragile' => 'Not fragile',
        'with_carriers_with_handling' => 'With handling',
        'with_carriers_with_parking' => 'With parking',
        'with_carriers_without_handling' => 'Without handling',
        'with_carriers_without_parking' => 'Without parking',
        'without_carriers' => 'Without carriers',
        'without_carriers_<=6m3_floors_=0' => 'RDC',
        'without_carriers_<=6m3_floors_>=1' => 'Floor ≥ 1',
        'without_carriers_>6m3_floors_=0' => 'RDC',
        'without_carriers_>6m3_floors_>=1' => 'Floor ≥ 1',
        'without_carriers_fragile' => 'Fragile',
        'without_carriers_not_fragile' => 'Not fragile',
        'without_carriers_with_parking' => 'With parking',
        'without_carriers_without_parking' => 'Without parking',
    ],


//	"Welcome in the manager" => "Welkom bij onze manager",
//	"See my stuff" => "Mijn spullen bekijken",
//	"Schedule a pickup" => "Mijn spullen opslaan",
//	"Select for pickup" => "Een opslag plannen",
//	"Reschedule" => "Herplannen",
//	"You don't have any items" => "Ik heb nog niets opgeslagen, <a href=\"/user/pickup\">kom mijn spullen ophalen</a>",
//	"Welcome" => "Welkom",
//	"Select for reschedule" => "Selecteer een artikel om het opnieuw in te plannen",
//	"Select to get back" => "Selecteer een artikel om het terug te laten bezorgen",
//	"Items in storage" => "Mijn opgeslagen spullen",
//	"Items in transit" => "Artikelen die onderweg zijn",
//	"Items with me" => "Artikelen die bij mij staan",
//	"Select for delivery" => "Selecteer een artikel",
//	"Items" => "Artikel",
//	"in_storage" => "opgeslagen",
//	"in_transit" => "onderweg",
//	"with_me" => "bij mij",
//	"We will drop" => "Wij bezorgen",
//	"We will drop back" => "Wij halen op",
//	"I want this item back !" => "Ik wil iets terug !",
//	"Stored on" => "Opgeslagen op",
//	"Scheduled on" => "Gepland op",
//	"See all" => "Alles zien",
//	'Enter your full address' => 'Geef uw adres in',
//	'box' => 'doos',
//	'Additionnal delivery instructions' => 'Bijkomende leveringsinstructies',
//	"Please select an available date" => "Gelieve een beschikbare datum te kiezen",
//	"success_in_transit" => "Uw leveringsaanvraag werd succesvol verplaatst",
//	"success_with_me" => "Uw leveringsaanvraag werd succesvol verplaatst",
//	"success_in_storage" => "We hebben uw aanvraag tot teruggave goed ontvangen en behandelen ze zo snel mogelijk.",
//	"1€ reduction shipping fee for each month you store starting from storage date to " => "Elke maand 1€ korting op de leveringskosten, vanaf de startdatum van opslag tot teruggave:"
];
