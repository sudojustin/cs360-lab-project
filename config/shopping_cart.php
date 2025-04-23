<?php

return [
    /*
     * ---------------------------------------------------------------
     * formatting
     * ---------------------------------------------------------------
     *
     * the formatting of shopping cart values
     */
    'format_numbers' => env('SHOPPING_FORMAT_VALUES', false),

    'decimals' => env('SHOPPING_DECIMALS', 0),

    'dec_point' => env('SHOPPING_DEC_POINT', '.'),

    'thousands_sep' => env('SHOPPING_THOUSANDS_SEP', ','),

    /*
     * ---------------------------------------------------------------
     * persistence
     * ---------------------------------------------------------------
     *
     * the configuration for persisting cart
     */
    'storage' => \Darryldecode\Cart\Storage\SessionStorage::class,

    /*
     * ---------------------------------------------------------------
     * events
     * ---------------------------------------------------------------
     *
     * the configuration for cart events
     */
    'events' => null,
    
    /*
     * ---------------------------------------------------------------
     * cart limits
     * ---------------------------------------------------------------
     *
     * the configuration for cart item limits and validation
     */
    'max_items' => 100, // Set a high limit for number of unique items
];