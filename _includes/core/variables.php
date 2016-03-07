<?php

use BP\Variables;

/**
 * Variables Object
 */
$_variables = new Variables($_config);

/**
 * Add Variable
 *
 * @since 1.0.0
 *
 * $name: (string) name of the variable to add
 * $value: (mixed) value to add
 */
function set( $name, $value = false ) {

    # Get Variables Object
    global $_variables;

    # Add Variable
    $_variables->set( $name, $value );

}

/**
 * Get Variable
 *
 * @since 1.0.0
 *
 * $name: (string) name of the variable to get
 */
function get( $name = null ) {

    # Get Variables Object
    global $_variables;

    # Get Variable
    if ( !is_null($name) ) {
        return $_variables->get( $name );
    }

    # Get All Variables
    return $_variables->get();

}

/**
 * Get Variables
 *
 * @since 1.0.0
 */
function vars() {
    return get();
}

# Debug helpers
set('dev', array(
    'localhost' => is_localhost()
));

# Page variables
set('page', array(
    'is_home'   => is_home(),   # True if current path is index
    'path'      => $_path,      # Path as it comes (e.g. services/design)
    'index'     => $_index,     # Path index
    'slug'      => get_page()   # Formatted page ID (e.g. services-design)
), true);

# Various useful variables
set('this_year', this_year());
