<?php

/**
 * Check if we're
 * viewing from
 * local machine
 *
 * @since 1.0.0
 */
function is_localhost() {

    $hosts = array(
        '127.0.0.1',
        '::1',
        'localhost'
    );

    if ( extras_enabled() ) {
        $hosts = apply_filters('is_localhost', $hosts);
    }

    return in_array($_SERVER['REMOTE_ADDR'], $hosts);

}

/**
 * Check page
 * Returns true is
 * current page matches
 * input string
 *
 * Will check for homepage
 * if no argument
 *
 * @since 1.0.0
 *
 * $check: (string) path to check
 */
function is_page( $check = null ) {
    $page = (is_null($check) ? 'index' : $check);
    return $page === get_page();
}

/**
 * Check path
 *
 * @since 1.0.0
 *
 * $check: (string) path to check
 */
function is_path( $check ) {
    global $_path;
    return $check === $_path;
}

/**
 * Path Contains
 *
 * Check to see if path
 * contains a given string
 * at any place.
 *
 * @since 1.0.0
 *
 * $string: (string) string to check for
 */
function path_contains( $string ) {
    global $_path;
    return preg_match('/' . preg_quote($string, '/') . '/', $_path);
}

/**
 * URI Has Query
 *
 * Check the $_GET superglobal to
 * see if a query string exists
 *
 * @since 1.0.4
 * @param $key: (string) key to look for
 * @return (bool)
 */
function uri_has_query( $key ) {
    return isset($_GET[$key]);
}

/**
 * Is Index
 *
 * Check the first index
 *
 * @since 1.0.0
 *
 * $check: (string) index key to check
 */
function is_index( $check = null ) {
    global $_index;
    return $check == $index[0];
}

/**
 * Check to see if
 * current page is
 * homepage
 *
 * @since 1.0.0
 */
function is_home() {
    return is_page();
}

/**
 * Get Current Page
 * Return the formatted slug of the current page
 *
 * @since 1.0.0
 */
function get_page() {

    # Get path
    global $_path;

    # Remove slashes
    $uri = str_replace('/', '-', ltrim($_path, '/'));

    return $uri;

}
