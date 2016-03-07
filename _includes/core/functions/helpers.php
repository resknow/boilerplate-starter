<?php

/**
 * Get current year for
 * copyright notice
 *
 * @since 1.0.0
 */
function this_year() {

    $year = date('Y');

    if ( extras_enabled() ) {
        $year = apply_filters('this_year', $year);
    }

    return $year;
    
}
