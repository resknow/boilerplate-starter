<?php

use BP\Triggers;

# Create Triggers Object
$_triggers = new Triggers();

/**
 * Add Trigger
 * @global $_triggers
 *
 * @since 1.0.2
 */
function add_trigger( $trigger ) {
    global $_triggers;
    $_triggers->add_trigger($trigger);
}

/**
 * Do Trigger
 * @global $_triggers
 *
 * @since 1.0.2
 */
function do_trigger() {
    global $_triggers;
    call_user_func_array( array( $_triggers, 'do_trigger' ), func_get_args() );
}

/**
 * Add Action
 * @global $_triggers
 *
 * @since 1.0.2
 */
function add_action( $trigger, $action ) {
    global $_triggers;

    $args = func_get_args();
    unset($args[0]);
    unset($args[1]);

    call_user_func_array(array($_triggers, 'add_action'), array_merge(array(
        $trigger,
        $action
    ), $args));
}

/**
 * Remove Action
 * @global $_triggers
 *
 * @since 1.5.3
 */
function remove_action( $trigger, $action ) {
    global $_triggers;
    return $_triggers->remove_action($trigger, $action);
}
