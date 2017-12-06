<?php

return  [

    /**
     * type of properties - change or add only
     */
    'types' =>
        [
            '1' => 'House',
            '2' => 'Apartment',
            '3' => 'Land',
            '4' => 'Flat'
        ],

    /**
     * operation defines
     */
    'operation' => [
        '1' => 'Rent',
        '2' => 'Buy',
        '3' => 'Sold'
    ],

    /**
     * square measures array - change or add only
     */
    'square_measure' =>
        [
            '1' => 'm²',
            '2' => 'ft²',
            '3' => 'ha',
            '4' => 'ac',
            '5' => 'km²',
            '6' => 'mi²'
        ],

    /**
     *  rent during measures & math coefficient for search
     */
    'rent_measure' =>
        [
            '1' => 'daily',
            '7' => 'weakly',
            '30' => 'monthly',
            '365' => 'yearly',
        ],

    /**
     * cloudinary
     */
    'cloudinary' =>
        [
            'max_width' => '800',
            'path' => 'http://res.cloudinary.com/realtor222/image/upload/',
        ],

    /**
     * money
     */
    'money' => '$',

    /**
     * roles
     */
    'roles' =>
        [
            '1' => 'client',
            '2' => 'agent',
            '10' => 'admin'
        ]
];