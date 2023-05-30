<?php

return [
    'title' => 'Sponsorship',

    'tabs' => [
        'sponsorship' => 'Sponsorship',
        'my_sponsorship' => 'My sponsorship',
    ],

    'modal' => [
        'image' => 'assets/img/email-verification.png',
        'title' => "{0} Votre invitation n'a pas été envoyée|Votre invitation a bien été envoyé|Vos invitations ont bien été envoyées",
        'sub-title' => 'Cet email a déjà un compte|Ces emails ont déjà un compte',
    ],

    'share' => [
        'facebook' => [
            'link' => 'https://www.facebook.com/sharer.php?u={url}',
            'text' => 'Share',
        ],
        'twitter' => [
            'link' => 'https://twitter.com/intent/tweet?url={url}&text={title}&via={user_id}&hashtags={hash_tags}',
            'text' => 'Tweet',
        ],
        'email' => [
            'link' => 'mailto:{email_address}?subject={title}&body={url}',
            'text' => 'Mail',
        ],
    ],

    'status' => [
        'valid' => 'Validé',
        'not_valid' => 'Non validé',
    ],

    'sponsorship' => [
        'intro' => 'Si un user a commandé et validé sa commande en venant de votre lien, vous gagnez un coupon et lui xx% sur sa commande',

        'link' => [
            'title' => 'Copier et partager votre lien de parrainage',
            'your_link' => 'Votre lien de parrainage',
            'button' => 'Copier',
        ],

        'invitation' => [
            'title' => 'Envoyer une invitation à vos amis',
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Email',
            ],
            'add' => 'Ajouter un email',
            'submit' => 'Envoyer les invitations',
        ],
    ],

    'my_sponsorship' => [
        'title' => 'Vous avez été parrainé par : {user.name}',

        'table' => [
            'referrals' => 'Referrals',
            'validation' => 'Validation',
            'coupon' => 'Coupon',
            'resend' => 'Resend',
        ],
    ],
];
