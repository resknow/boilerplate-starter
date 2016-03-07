<?php

/**
 * Extras Enabled
 *
 * @deprecated as of 1.4.1 - will always return true for
 * backwards compatibility with plugins using this
 * function.
 *
 * @return (bool) True
 */
function extras_enabled() {
    return true;
}

/**
 * Get Extras
 *
 * @deprecated as of 1.4.1 - will be removed in a future update.
 *
 * @return (array) Array of includes.
 */
function get_extras() {
    return glob('_includes/extras/**/init.php');
}
