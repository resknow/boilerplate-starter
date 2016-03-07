<?php

# Load Extras check
require_once ROOT_DIR . '/_includes/core/functions/extras.php';

# Load Filters & Triggers
require_once ROOT_DIR . '/_includes/core/functions/filters.php';
require_once ROOT_DIR . '/_includes/core/functions/triggers.php';

# Get Plugin functions.php
$_plugin_functions = glob('_plugins/**/functions.php');

# Include Plugin functions.php
if ( is_array($_plugin_functions) ) {

    foreach ( $_plugin_functions as $plugin ) {
        require_once $plugin;
    }

    # Trigger: template_functions_loaded
    do_trigger('plugin_functions_loaded');

}

# Get theme functions.php
#
# @NOTE This is optional but can be useful
# for applying filters as they need to be
# declared before they get executed!
if ( file_exists('_templates/functions.php') ) {

    require_once ROOT_DIR .  '/_templates/functions.php';

    # Trigger: template_functions_loaded
    do_trigger('template_functions_loaded');

}

# Get Functions
require_once ROOT_DIR . '/_includes/core/functions/forms.php';
require_once ROOT_DIR . '/_includes/core/functions/helpers.php';
require_once ROOT_DIR . '/_includes/core/functions/http.php';
require_once ROOT_DIR . '/_includes/core/functions/path.php';
require_once ROOT_DIR . '/_includes/core/functions/plugins.php';
require_once ROOT_DIR . '/_includes/core/functions/system.php';
require_once ROOT_DIR . '/_includes/core/functions/theme.php';

# Include after Plugin functions are loaded
require_once ROOT_DIR . '/_includes/core/variables.php';

# Trigger: variables_loaded
do_trigger('variables_loaded');

# Get available plugins
$_plugin_files = glob('_plugins/**/plugin.php');

# Include plugins
if ( is_array($_plugin_files) ) {
    foreach ( $_plugin_files as $plugin ) {
        require_once $plugin;
    }
}

# Trigger: plugins_loaded
do_trigger('plugins_loaded');
