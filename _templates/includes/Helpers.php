<?php

namespace Starter;

class Helpers {

    public function __construct() {
        add_action( 'variables_loaded', array( $this, 'add_address_vars' ) );
    }

    /*
     * Address Vars
     */
    public function add_address_vars() {

        // Get Address
        if ( ! $address = get('site.address') ) {
            return false;
        }

        // Replace address with multiple versions
        set('site.address', array(
            'simple'    => $address,
            'long'      => str_replace(', ', '<br>', $address)
        ));

    }

}
