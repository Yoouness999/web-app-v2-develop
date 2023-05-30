<?php

return [
    'title' => 'Gérer',

    'card' => [
        'drop' => 'Nous vous livrerons',
        'drop_back' => 'Nous vous livrerons en retour',
        'no_picture' => 'Pas de photo',
        'pickup_date' => 'Planifié pour le',
        'storage_date' => 'Stocké le',
    ],

    'filters' => [
        'search' => 'Chercher',
        'sort_by' => 'Trier par',
        'sorting' => [
            '-storage_date' => 'Date ↑',
            '+storage_date' => 'Date ↓',
            '+description' => 'Nom ↓',
            '-description' => 'Nom ↑',
        ],
        'types' => [
            'in_transit' => 'En transit',
            'in_storage' => 'Stockés',
            'with_me' => 'Chez moi',
        ],
    ],

    'form' => [
        'reschedule' => 'Replanifier',
        'want_back' => 'Je veux le récupérer',
        'address' => 'Entrer votre adresse complète',
        'number' => 'Numéro',
        'box' => 'Boïte',
        'postalcode' => 'Code postal',
        'city' => 'Ville',
        'delivery_instructions' => 'Instructions de livraison additionnelles',
        'available_date' => 'Veuillez choisir une date disponible',
        'wait-fill-boxes' => 'Attendre 20 minutes le temps de remplir les boites',
        'button_reschedule' => 'Replanifier',
        'button_get_back' => 'Récupérer',
        'button_cancel' => 'Annuler',
        'thank_you' => 'Merci',
    ],

    'insurances' => [
        'base' => 'Basic',
        'normal' => '1000€',
        'medium' => '2500€',
        'on_demand' => '+2500€',
    ],

    'items' => [
        'no_items' => 'Vous n\'avez pas d\'articles',

        'tabs' => [
            'in_storage' => 'Articles stockés',
            'in_transit' => 'Articles en transit',
            'with_me' => 'Articles chez moi',
        ],

        'title' => [
            'in_storage' => 'Séléctionner l\'objet pour le reprendre',
            'in_transit' => 'Séléctionner l\'objet pour le replanifier',
            'with_me' => 'Article chez moi',
        ],
        'has_selection' => [
            'in_storage' => 'Je veux le récupérer !',
            'in_transit' => 'Replanifier',
        ],
    ],

    'modals' => [
        'cancel' => 'Annuler',
        'insurance' => 'Voulez vraiment modifier le montant de l\'assurance ?',
        'storing_duration' => 'Voulez vraiment modifier la durée d\'engagement ?',
        'ok' => 'Confirmer',
    ],

    'plans' => [
        'item' => 'Boîtes',
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
        'plan' => 'Votre plan',
        'engagement' => 'Engagement',
        'insurance' => 'Assurance',
        'price' => '{{price}} €/mois',
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



//	"Welcome in the manager" => "Bienvenue dans votre manager",
//	"See my stuff" => "Voir mes affaires",
//	"Schedule a pickup" => "Stocker mes affaires",
//	"Select for pickup" => "Planifier un ramassage",
//	"Reschedule" => "Replanifier",
//	"You don't have any items" => "Il n'y a aucun objet, <a href=\"/user/pickup\">venez chercher mes affaires</a>",
//	"Welcome" => "Bonjour",
//	"Select for reschedule" => "Selectionner l'objet pour le replanifier",
//	"Select to get back" => "Selectionner l'objet pour le reprendre",
//	"Items in storage" => "Articles stockés",
//	"Items in transit" => "Articles en transit",
//	"Items with me" => "Articles chez moi",
//	"Select for delivery" => "Selectionner un article",
//	"Items" => "Articles",
//	"in_storage" => "stockés",
//	"in_transit" => "en transit",
//	"with_me" => "chez moi",
//	"We will drop" => "Nous vous livrerons",
//	"We will drop back" => "Nous vous livrerons en retour",
//	"I want this item back !" => "Je le veux de retour !",
//	"Stored on" => "Stocké le ",
//	"Scheduled on" => "Planifié pour le",
//	"See all" => "Voir tout",
//	'Enter your full address' => 'Entrez votre adresse complète',
//	'box' => 'boite',
//	'Additionnal delivery instructions' => 'Instructions de livraison additionnelles',
//	"Please select an available date" => "Veuillez choisir une date disponible",
//	"success_in_transit" => "Votre demande de livraison à été reprogrammée avec succès",
//	"success_with_me" => "Votre demande de livraison à été reprogrammée avec succès",
//	"success_in_storage" => "Nous avons bien reçu votre demande de retour, nous la traitons dans les plus brefs délais.",
//	"1€ reduction shipping fee for each month you store starting from storage date to " => "1€ de réduction sur le coût de livraison pour chaque mois de la date du début du stockage jusqu'au retour :"
];
