<?php

/**
 * Get Request Method
 *
 * Returns method used by
 * current request. Useful for
 * API/AJAX requests.
 */
function get_request_method() {
    return $_SERVER['REQUEST_METHOD'];
}
