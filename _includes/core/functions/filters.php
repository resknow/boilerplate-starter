<?php

use BP\Filters;

# Create Filters Object
$_filters = new Filters();

/**
 * Add Filter
 *
 * @since 1.0.0
 *
 * $hook: (string) name of the filter hook
 * $name: (string) name of the callback function
 * @deprecated $args: (int) number of arguments
 * $priority: (int) the execution priority (lower = run first)
 */
function add_filter( $hook, $name, $args = 1, $priority = 10 ) {

    # Get Filters Object
    global $_filters;

    # Add Filter
    $_filters->add_filter( $hook, $name, $args, $priority );

}

/**
 * Apply Filters
 *
 * @since 1.0.0
 *
 * $hook: (string) name of the filter hook
 * $input: (mixed) value to filter
 */
function apply_filters( $hook, $input ) {

    # Get Filters Object
    global $_filters;

    # Apply Filters
    return $_filters->apply_filters( $hook, $input );

}
