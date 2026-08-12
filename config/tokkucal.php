<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    |
    | Used across layouts, structured data, and SEO meta defaults so these
    | values only need to be changed in one place.
    |
    */

    'site_name' => env('APP_NAME', 'Tokkucal'),

    'tagline' => 'Free Tools for Everyday Life',

    'description' => 'Fast, simple and free online calculators and utility tools for everyday life in India.',

    'default_og_image' => '/images/og-default.png',

    'contact_email' => env('CONTACT_EMAIL'),

    'developer' => 'HappyX Solution',

    /*
    |--------------------------------------------------------------------------
    | Tool Categories
    |--------------------------------------------------------------------------
    |
    | Central list of category keys used to group tools on the homepage and
    | in navigation. Keep in sync with the `category` column values used by
    | the ToolSeeder.
    |
    */

    'categories' => [
        'money' => 'Money Tools',
        'student' => 'Student Tools',
        'image' => 'Image Tools',
        'utility' => 'Utility Tools',
    ],

];
