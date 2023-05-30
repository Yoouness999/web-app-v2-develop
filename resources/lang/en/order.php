<?php

$months = array_map(function ($item) {
    return str_pad($item + 1, 2, '0', STR_PAD_LEFT);
}, range(0, 11));
$months = array_combine($months, $months);

// @see https://stackoverflow.com/questions/2500588/maximum-year-in-expiry-date-of-credit-card
$years = range(date('Y'), date('Y') + 10);
$years = array_combine(range(date('y'), date('y') + 10), $years);

return [
    'breadcrumb' => [
        'steps' => [
            '1' => 'Storage',
            '2' => 'Services',
            '3' => 'Appointment',
            '4' => 'Billing',
            '5' => 'Review',
        ],
    ],

    'faq' => [
        'title' => 'Frequently Asked Questions',
        '1' => [
            'title' => 'Lorem ipsum dolor sit amet?',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
        ],
        '2' => [
            'title' => 'Lorem ipsum dolor sit amet?',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
        ],
    ],

    'items' => [
        'sofa_2_seater' => "Sofa (2 seater)",
        'sofa_3_seater' => "Sofa (3 seater)",
        'corner_sofa' => "Corner sofa",
        'chaise_longue' => "Chaise longue",
        'armchair' => "Armchair",
        'footstool' => "Footstool",
        'coffee_table' => "Coffee table",
        'side_table' => "Side table",
        'bookcase' => "Bookcase",
        'tv_cabinet' => "TV cabinet",
        'tv_bench' => "TV bench",
        'tv_' => "TV ",
        'piano' => "Piano",
        'rug' => "Rug",
        'floor_lamp' => "Floor lamp",
        'picture_frame' => "Picture frame",
        'artificial_plant' => "Artificial plant",

        'dining_table' => "Dining table",
        'breakfast_table_(4_seater)' => "Breakfast table (4 seater)",
        'dining_chair' => "Dining chair",
        'stool' => "Stool",
        'bar_stool' => "Bar stool",
        'highchair' => "Highchair",
        'display_cabinet' => "Display cabinet",
        'sideboard' => "Sideboard",
        'fridge' => "Fridge",
        'freezer' => "Freezer",
        'fridge_with_freezer' => "Fridge with freezer",
        'american_fridge' => "American fridge",
        'dish_washer' => "Dish washer",
        'oven' => "Oven",
        'microwave' => "Microwave",
        'bin' => "Bin",
        'tea_cart' => "Tea cart",

        'double_bed' => "Double bed",
        'single_bed' => "Single bed",
        'headboard' => "Headboard",
        'double_mattress' => "Double mattress",
        'single_mattress' => "Single mattress",
        '2-door_wardrobe' => "2-door wardrobe",
        '4-door_wardrobe' => "4-door wardrobe",
        'bedside_table' => "Bedside table",
        'chest_of_drawers' => "Chest of drawers",
        'dresser_6_drawers' => "Dresser (6 drawers)",
        'dressing_table' => "Dressing table",
        'floor_lamp2' => "Floor lamp",
        'ac_unit' => "AC unit",
        'rug2' => "Rug",
        'mirror' => "Mirror",
        'picture_frame2' => "Picture frame",

        'changing_table' => "Changing table",
        'cot' => "Cot",
        'children_bed' => "Children's bed",
        'bunk_bed' => "Bunk bed",
        'children_wardrobe' => "Children's wardrobe",
        'chest_of_drawers2' => "Chest of drawers",
        'children_table' => "Children's table",
        'children_chair' => "Children's chair",
        'desk' => "Desk",
        'chair' => "Chair",
        'bookcase2' => "Bookcase",
        'baby_bath' => "Baby bath",
        'toy_box' => "Toy box",
        'rug3' => "Rug",

        'desk2' => "Desk",
        'office_chair' => "Office chair",
        'filing_cabinet' => "Filing cabinet",
        'lamp_table' => "Lamp table",
        'large_file_cabinet' => "Large file cabinet",
        'bookcase3' => "Bookcase",
        'shelving_unit' => "Shelving unit",
        'paper_bin' => "Paper bin",
        'picture_frame3' => "Picture frame",
        'archive_box' => "Archive box",

        'washing_machine' => "Washing machine",
        'tumble_dryer' => "Tumble dryer",
        'drying_rack' => "Drying rack",
        'Ironing_board' => "Ironing board",
        'laundry_basket' => "Laundry basket",
        'linen_rack' => "Linen rack",
        'vacuum_cleaner' => "Vacuum cleaner",
        'shoe_rack' => "Shoe rack",
        'bin2' => "Bin",

        'garden_table' => "Garden table",
        'garden_chair' => "Garden chair",
        'garden_bencj' => "Garden bencj",
        'garden_bench' => "Garden bench",
        'lawn_mower' => "Lawn mower",
        'outdoor_grill' => "Outdoor grill",
        'garden_tools' => "Garden tools",
        'garden_heater' => "Garden heater",

        'workbench' => "Workbench",
        'toolbox' => "Toolbox",
        'ladder' => "Ladder",
        'suitcase' => "Suitcase",
        'trolley' => "Trolley",

        'moving_box_small' => "Moving box small",
        'moving_box_medium' => "Moving box medium",
        'moving_box_large' => "Moving box large",

        'adult_bicycle' => "Adult's bicycle",
        'kid_bicycle' => "Kid's bicycle",
        'ski' => "Ski",
        'golf_club' => "Golf club",
        'snowboard' => "Snowboard",
        'surfboard' => "Surfboard",

        'boxify_box' => 'Boxify box',
        'wardobe_box' => 'Wardobe box',
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

    'storing-duration' => [
        '-6_months' => '-6 months',
        '6_months' => '> 6 months',
        '3_months' => '3 Months Term',
        '12_months' => '12 Months Term',
    ],

    'assurances' => [
        'base' => 'Base',
        'normal' => '1000€',
        'medium' => '2500€',
        'on_demand' => '+2500€',
    ],

    'resume' => [
        'title' => 'Your monthly total',
        'appointment' => 'Appointment',
        'services-title' => 'Pickup Services',
        'storing-duration' => 'Durée',
        'assurance' => 'Insurance',
        'assets-title' => 'Included Features',
        'assets-price' => 'Free',
        'terms' => 'I have read and agree to the Boxify terms and services',
        'submit' => 'Confirm',
        'notice' => 'Sous réserve de l’exactitude des informations transmises par le client',
        'services' => [
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
    ],

    'storage' => [
        'title' => 'Pick up a storage plan',
        'total' => 'Total size of your items:',
        'price' => 'month',
        'select-plan' => 'Select plan',
        'categories' => [
            'small' => 'Small',
            'medium' => 'Medium',
            'large' => 'Large',
            'x_large' => 'X-Large',
        ],
        'calculator' => [
            'title' => 'Not sure which plan to pick?',
            'content' => 'Our easy-to-use storage calculator will help you find the right plan.',
            'button' => 'Calculate the space you need',
        ],
        'plans-detail' => [
            'include' => [
                'title' => 'Our plans include',
            ],
            'contact' => [
                'title' => 'Need a larger space?',
                'content' => 'Speak to a storage expert and they can help find the right space to fit your needs.',
                'phone' => 'Call us:',
            ],
        ],

        'plan' => [
            'title' => 'This is the plan we recommend for you:',
            'submit' => 'Select this plan',
            'contact-only' => 'Speak to a storage expert',
            'resume' => [
                'total' => 'Total size of your items:',
            ],
            'includes' => [
                'title' => 'This plan includes',
            ],
        ],
    ],

    'calculator' => [
        'title' => 'Find the right plan',
        'subtitle' => 'Enter the quantity for each item that you need to store and we’ll recommend the right plan for you.',
        'total' => 'Total size of your items:',
        'find' => 'Find me a plan',
        'current_plan' => 'Your current plan',

        'storage-supplies' => [
            'title' => 'Storage supplies',
        ],

        'categories' => [
            'living_room' => 'Living room',
            'kitchen_dining' => 'Kitchen & dining',
            'bedroom' => 'Bedroom',
            'children_room' => "Children's room",
            'office' => 'Office',
            'laundry_cleaning' => 'Laundry & cleaning',
            'garden' => 'Garden',
            'garage' => 'Garage',
            'boxes' => 'Boxes',
            'sports_equipment' => 'Sports equipment',
            "storage_supplies" => 'Storage supplies'
        ],
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
    ],

    'appointment' => [
        'title' => 'Appointment',
        'submit' => 'Continue to billing',
        'address' => [
            'label' => 'Where should we meet you at ?',
            'street_number' => [
                'placeholder' => 'Street number',
            ],
            'route' => [
                'placeholder' => 'Route',
            ],
            'box' => [
                'placeholder' => 'bte',
            ],
            'postal_code' => [
                'placeholder' => 'Postal code',
            ],
            'locality' => [
                'placeholder' => 'Locality',
            ],
        ],
        'dropoff' => [
            'label' => 'When should we drop-off ?',
            'placeholder' => 'Choose a date',
        ],
        'pickup' => [
            'label' => 'When should we pick it all?',
            'placeholder' => 'Choose a date',
        ],
        'wait-fill-boxes' => [
            'label' => 'Attendre 20 minutes le temps de remplir les boites',
            'pickup-time' => '+20min',
        ],
        'storing-duration' => [
            'label' => 'Durée de stockage',
            '-6_months' => '-6 mois',
            '6_months' => '> 6 mois',
            '12_months' => '> 12 mois',
        ],
    ],

    'billing' => [
        'title' => 'Payment information',
        'subtitle' => 'Choisissez votre type de paiement',
        'card-error' => 'Card refused',
        'sepa-error' => 'Iban refused',
        'deposit-error' => 'Minimal deposit refused',
        'payment-type' => [
            'credit-card' => 'Credit card <small>2% fees</small>',
            'sepa' => 'Bank card',
        ],
        'card-number' => [
            'label' => 'Card number',
            'placeholder' => 'Required',
        ],
        'expiration-date' => [
            'label' => 'Expiration date',
            'placeholder' => 'MM/YY',
        ],
        'expiration-month' => [
            'placeholder' => 'MM',
            'options' => $months,
        ],
        'expiration-year' => [
            'placeholder' => 'YYYY',
            'options' => $years,
        ],
        'security-code' => [
            'label' => 'Security code',
            'placeholder' => 'CVC',
            'help' => 'Regardez le dos de votre carte pour trouver le code à trois chiffres situé après votre numéro de carte.',
        ],
        'card-name' => [
            'label' => 'Name on card',
            'placeholder' => 'Required',
        ],
        'iban' => [
            'label' => 'IBAN',
            'placeholder' => 'BEXX XXXX XXXX XXXX',
        ],
        'iban-owner' => [
            'label' => 'Owner name',
            'placeholder' => 'Required',
        ],
        'notabene' => 'This form is secure and encrypted',
        'submit' => 'Continue to review',
    ],

    'review' => [
        'title' => 'Your storage plan details',
        'terms' => 'I have read and agree to the Boxify terms and services',
        'submit' => 'Confirm',
        'account' => [
            'register' => [
                'title' => 'Create your account',
                'facebook' => 'Create account with Facebook',
                'button' => 'Continue',
                'link' => 'Already have an account? Please :beforeLink login :afterLink.',
            ],
            'login' => [
                'title' => 'Login to your account',
                'facebook' => 'Login with Facebook',
                'button' => 'Continue',
                'link' => 'Do not have an account? Please :beforeLink register :afterLink.',
                'error' => 'The email and password you entered do not match. Please try again.',
            ],
            'update' => [
                'title' => 'Your account',
            ],
            'first-name' => [
                'placeholder' => 'First name',
            ],
            'last-name' => [
                'placeholder' => 'Last name',
            ],
            'phone' => [
                'placeholder' => 'Phone number',
            ],
            'email' => [
                'placeholder' => 'Email',
                'error' => 'Email is not available.',
            ],
            'password' => [
                'placeholder' => 'Password',
            ],
            'password_confirmation' => [
                'placeholder' => 'Password Confirmation',
            ],
        ],
        'booking-overview' => [
            'title' => 'Booking overview',
            'price' => '€:price/month',
            'storage-supplies' => 'Your plan includes free bins and wardrobe boxes. Let us know if you need any.',
            'help' => '*Les boîtes doivent être rendues en bon état après stockage',
        ],
        'assurance' => [
            'title' => 'Do you want an assurance option?',
            'on_demand' => 'On demand',
            'free' => 'Free',
        ],
        'appointment' => [
            'title' => 'Appointment',
            'dropoff' => 'Dropoff',
            'edit' => 'Edit',
            'pickup' => 'Pickup',
            'address' => 'Address',
            'comments' => [
                'label' => 'Special instructions',
                'placeholder' => 'Ex: my buzzer is broken, no elevator, ...',
            ],
            'billing_address' => 'Different billing address?',
            'company_address' => 'Company billing address?',
        ],
        'billing' => [
            'title' => 'Billing',
            'edit' => 'Edit',
            'coupon' => [
                'placeholder' => 'Have you a promocode?',
            ],
            'name' => [
                'placeholder' => 'Company name',
            ],
            'vat-number' => [
                'placeholder' => 'VAT number',
            ],
            'address' => [
                'placeholder' => 'Address',
            ],
            'street_number' => [
                'placeholder' => 'Street number',
            ],
            'locality' => [
                'placeholder' => 'Locality',
            ],
            'box' => [
                'placeholder' => 'Bte',
            ],
            'postal_code' => [
                'placeholder' => 'Postal code',
            ],
            'country' => [
                'placeholder' => 'Country',
            ],
        ],
        'company' => [
            'title' => 'Billing Address',
            'name' => [
                'placeholder' => 'Company name',
            ],
            'vat-number' => [
                'placeholder' => 'VAT number',
            ],
            'address' => [
                'placeholder' => 'Address',
            ],
            'street_number' => [
                'placeholder' => 'Street number',
            ],
            'locality' => [
                'placeholder' => 'Locality',
            ],
            'box' => [
                'placeholder' => 'Bte',
            ],
            'postal_code' => [
                'placeholder' => 'Postal code',
            ],
            'country' => [
                'placeholder' => 'Country',
                'options' => [
                    'BE' => 'Belgium',
                    'NL' => 'Nederland',
                ],
            ],
        ],
        'how-did-your-hear-about-us' => [
            'title' => 'How did you hear about us?',
            'placeholder' => 'Select an option',
            'options' => [
                'google-advertising' => 'Google advertising',
                'yelp' => 'Yelp',
                'boxify-customer' => 'Boxify customer',
                'facebook' => 'Facebook',
                'instagram' => 'Instagram',
                'tv' => 'TV',
                'radio' => 'Radio',
                'other-website' => 'Other website',
                'other' => 'Other',
            ],
            'comment' => [
                'placeholder' => '',
            ],
        ],
        'storage' => [
            'edit' => 'Edit storage',
        ],
    ],

    'confirmation' => [
        'title' => 'Merci pour votre commande',
        'number' => 'Numéro de commande',
        'items' => [
            'boxify_box' => [
                'singular' => 'Boxify box',
                'plural' => 'Boxify boxes',
            ],
        ],
        'assurance' => [
            'title' => 'Assurance',
            'free' => 'Free',
            'items' => [
                'base' => 'Base',
                'normal' => '10,00 €',
                'medium' => '25,00 €',
                'on_demand' => '+25,00 €',
            ],
        ],
        'total' => 'Total',
        'follow' => 'Suivez votre commande et accédez à votre profile',
        'client_space' => 'Espace client',
        'tips' => [
            'title' => 'Nos conseils pour préparer le stockage',
            'sub_title' => 'Remplissage des boites',
            'items' => [
                'Tous les meubles et biens à stocker doivent être démontés et protégés par vos soins.',
                'Débranchez le frigo, climatiseur ou la machine à laver 48h à l’avance et assurez-vous qu’il n’y ait plus d’eau.',
                'Tous les objets sont rangés dans des boîtes et protégés pour un transport plus sûr.',
                'Tous les biens sont au rez-de-chaussée 10 minutes avant l’arrivée du livreur.',
                'Les ampoules sont retirées des lampes pour un transport et un stockage sans casse.',
                'Toutes les boites doivent être fermées et identifiées par vos soins.',
                'Ne surchargez pas les boîtes, elles doivent pouvoir se refermer. Ne dépassez pas 25Kg par boîte.',
                'Nous récupérerons uniquement les biens que vous avez demandé à stocker, tous les biens additionnels doivent être rajoutés à votre commande au minimum 24h à l’avance.',
                'Vous devez réserver une zone de stationnement de 25m devant le bâtiment',
            ],
        ],
        'forbidden' => [
            'title' => 'Il est interdit de stocker',
            'items' => [
                [
                    'text' => 'Fragile',
                    'img' => '/assets/img/order/confirmation/picto-fragile.png',
                ],
                [
                    'text' => 'Armes, munitions et inflammables',
                    'img' => 'assets/img/order/confirmation/picto-flammable.png',
                ],
                [
                    'text' => 'Produits illégaux',
                    'img' => 'assets/img/order/confirmation/picto-illegal.png',
                ],
                [
                    'text' => 'Périssable',
                    'img' => 'assets/img/order/confirmation/picto-perishable.png',
                ],
            ],
        ],
        'faq' => [
            'title' => 'Liens pratiques de notre FAQ',
            'items' => [
                [
                    'text' => lg('pages/faq.accordions.2.items.2.title'),
                    'link' => '/fad#question2_2',
                ],
                [
                    'text' => lg('pages/faq.accordions.2.items.3.title'),
                    'link' => '/fad#question2_3',
                ],
                [
                    'text' => lg('pages/faq.accordions.3.items.1.title'),
                    'link' => '/fad#question3_2',
                ],
            ],
        ],
    ],

    'tooltips' => [
        '-6_months' => '',
        '6_months' => 'Your plan has a 6 month storage minimum, but you can get your stuff back whenever you want. If you need an item back before the 6 months are up, we\'ll just charge you for the remaining time.',
        '12_months' => 'Your plan has a 12 month storage minimum, but you can get your stuff back whenever you want. If you need an item back before the 12 months are up, we\'ll just charge you for the remaining time.',

        'resume' => [
            'services' => '',
        ],

        'services' => [
            'carriers' => '',
            'floors_with_carriers' => '',
            'floors_without_carriers_lte_6m3' => '',
            'handling' => '',
            'fragile_with_carriers' => '',
            'fragile_without_carriers' => '',
            'parking_with_carriers' => '',
            'parking_without_carriers' => '',
        ],
    ],
];
