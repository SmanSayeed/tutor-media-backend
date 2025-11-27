<?php

return [
    'company_info' => [
        'name' => 'Tutor Solution BD',
        'email' => 'support@tutorsolutionbd.com',
        'phone' => '+123 456 789',
        'website' => 'www.tutorsolutionbd.com',
        'description' => 'We understand that business can be chaotic. That’s where we come in. We’re focused on adding some much-needed balance to the mix.',
    ],
    'frontend_url' => 'http://localhost:3000',
    'timezone' => 'Asia/Dhaka',
    'theme' => [
        'primary_color' => '#008744',
        'secondary_color' => '#FFA700',
    ],
    'logo_favicon' => [
        'logo_light' => '/assets/client/logo.svg',
        'logo_dark' => '/assets/client/logo.svg',
        'favicon' => '/assets/client/logo.svg',
    ],
    'address' => [
        'country' => 'Bangladesh',
        'state' => 'Dhaka',
        'city' => 'Dhaka',
        'postal_code' => '1207',
        'address' => 'Dhaka, Bangladesh',
        'location' => 'https://maps.app.goo.gl/GZ9YQZa2v15d1LhY7',
    ],
    'referral' => [
        'joining' => 100,
    ],
    'social_medias' => [
        [
            'id' => 1,
            'name' => 'Facebook',
            'link' => 'https://www.facebook.com/jhon.doe',
            'icon' => 'ph ph-facebook-logo',
        ],
        [
            'id' => 2,
            'name' => 'Linkedin',
            'link' => 'https://linkedin.com/jhon_doe',
            'icon' => 'ph ph-linkedin-logo',
        ],
        [
            'id' => 3,
            'name' => 'Twitter',
            'link' => 'https://www.twitter.com/jhon_doe',
            'icon' => 'ph ph-twitter-logo',
        ],
        [
            'id' => 4,
            'name' => 'Instagram',
            'link' => 'https://www.instagram.com/jhon_doe',
            'icon' => 'ph ph-instagram-logo',
        ],
        [
            'id' => 5,
            'name' => 'Youtube',
            'link' => 'https://www.youtube.com/jhon_doe',
            'icon' => 'ph ph-youtube-logo',
        ],
        [
            'id' => 6,
            'name' => 'Tiktok',
            'link' => 'https://www.tiktok.com/jhon_doe',
            'icon' => 'ph ph-tiktok-logo',
        ],
    ],

    'otp' => [
        'expire_time' => 1,
        'digit_range' => [10000, 99999],
    ],

    'defaultCurrency' => [],

    'auth_providers' => [
        [
            'id' => 'google',
            'name' => 'Google',
            'is_enabled' => true,
        ],
        [
            'id' => 'facebook',
            'name' => 'Facebook',
            'is_enabled' => false,
        ],
        [
            'id' => 'github',
            'name' => 'Github',
            'is_enabled' => false,
        ],
        [
            'id' => 'twitter',
            'name' => 'Twitter',
            'is_enabled' => false,
        ],
        [
            'id' => 'linkedin',
            'name' => 'Linkedin',
            'is_enabled' => false,
        ],
    ],
    'footer_text' => 'All rights reserved.',
    'auth_left_sidebar_image' => '/assets/client/sign-in-img.webp',
    'mobile_app' => [
        'android' => [
            'link' => 'https://play.google.com/store/apps',
            'icon' => '/assets/client/android.svg',
        ],
        'ios' => [
            'link' => 'https://www.apple.com/app-store/',
            'icon' => '/assets/client/apple.svg',
        ],
    ],
    'admob' => [
        'androidAppId' => 'ca-app-pub-6030102340960445~2567958201',
        'iosAppId' => 'ca-app-pub-6030102340960445~4848181773',
    ],
];
