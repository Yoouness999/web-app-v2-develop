<?php

return [
    'title' => 'Account',

    'notification' => [
        'title' => 'DÉFAUT DE PAIEMENT',
        'description' => 'le solde de votre carte n’est pas suffisant, veuillez approvisionner votre carte. Après 2 tentatives infructueuses, des frais administratifs vous seront facturés. (si l’erreur est pas assez d’argent sur carte pour régler la facture)',
    ],

    'modal' => [
        'image' => 'assets/img/email-verification.png',
        'title' => 'Vous avez reçu un email de vérification.',
        'description' => 'Veuillez valider votre adresse email en suivant les instructions contenu dans cet email',
        'send_validation' => 'Renvoyer l\'email de confirmation',
    ],
	
	'modal-last-order-unpaid' => [
        'image' => 'assets/img/email-verification.png',
        'title' => 'Your last payment failed.',
        'description' => 'Please, check your payment informations and try again.',
        'link' => 'Go back to homepage',
    ],

    'tabs' => [
        'informations' => 'Informations',
        'billing' => 'Billing',
        'invoice' => 'Invoice',
        'password' => 'Password',
    ],

    'informations' => [
        'first_name' => [
            'label' => 'First name',
            'placeholder' => '',
        ],

        'last_name' => [
            'label' => 'Last name',
            'placeholder' => '',
        ],

        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Ex. +32 123456789',
        ],

        'email' => [
            'label' => 'Email',
            'placeholder' => 'Ex. your@mail.tld',
        ],

        'address' => 'Address',

        'route' => [
            'placeholder' => 'Route',
        ],

        'street_number' => [
            'placeholder' => 'Number',
        ],

        'box' => [
            'placeholder' => 'Box',
        ],

        'postal_code' => [
            'placeholder' => 'Postal code',
        ],

        'locality' => [
            'placeholder' => 'Locality',
        ],

        'country' => [
            'label' => 'Country',
            'placeholder' => 'Country',
        ],

        'is_billing_address' => 'Different billing address?',
        'is_company_address' => 'Company billing address?',

        'billing_address' => 'Billing address',

        'company_name' => [
            'label' => 'Company name',
            'placeholder' => 'Company name',
        ],

        'company_vat' => [
            'label' => 'VAT Number',
            'placeholder' => 'VAT Number',
        ],

        'company_address' => 'Company billing address',

        'submit' => 'Submit informations',
    ],

    'billing' => [
        'infos' => [
            'title' => 'Informations de paiement actuel',
            'next_billing' => 'Next billing',
            'next_billing_balance' => 'Next billing balance',
            'no_infos' => 'You don\'t have any payment information',
        ],

        'form' => [
            'title' => 'Update your payment method',
        ],
    ],

    'invoice' => [
        'statuses' => [
            \App\Invoice::STATUS_PAID => 'Paid',
            \App\Invoice::STATUS_UNPAID => 'Unpaid',
            \App\Invoice::STATUS_QUEUED => 'Queued'
        ],

        'table' => [
            'ref' => 'Ref',
            'date' => 'Date',
            'amount' => 'Amount',
            'status' => 'Status',
            'download' => 'Download',
        ],
    ],

    'password' => [
        'current_password' => [
            'label' => 'Current password',
            'placeholder' => 'Current password',
        ],

        'new_password' => [
            'label' => 'New password',
            'placeholder' => 'New password',
        ],

        'confirm_password' => [
            'label' => 'Confirm password',
            'placeholder' => 'Confirm password',
        ],

        'submit' => 'Save new password',
    ],

    'adyen_error' => 'Error on Adyen. Please try again later.',

];
