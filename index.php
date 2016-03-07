<?php

/**
 * @package Boilerplate
 * @version 1.5.3
 * @author Chris Galbraith
 *
 * This file is used to include everything
 * needed for the site to function properly.
 *
 * If you need to make changes, you'll probably
 * find what you need in _templates and any
 * plugins will be in _plugins.
 *
 */

use BP\Controller;
use BP\Theme;

# Start a Session
session_start();

# Define Root Directory
define('ROOT_DIR', __DIR__);

# Define Version
define('VERSION', '1.5.3');

# Autoload Dependencies & BP Classes
$composer = ROOT_DIR . '/_includes/vendor/autoload.php';
if ( file_exists($composer) ) {
    require_once $composer;
    unset($composer);
} else {
    require_once ROOT_DIR . '/_includes/core/classes/BP/Controller.php';
    require_once ROOT_DIR . '/_includes/core/classes/BP/Filters.php';
    require_once ROOT_DIR . '/_includes/core/classes/BP/Theme.php';
    require_once ROOT_DIR . '/_includes/core/classes/BP/Triggers.php';
    require_once ROOT_DIR . '/_includes/core/classes/BP/Variables.php';
    require_once ROOT_DIR . '/_includes/core/classes/Spyc.php';
}

# Load Site Config
$_config = Spyc::YAMLLoad(ROOT_DIR . '/.config.yml');

# For Development, show errors
if ( $_config['environment'] == 'dev' ) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
}

# Set Current Path
# @NOTE: Defaults to 'index' when no path is specified (e.g. homepage)
$_path   = (isset($_GET['path']) ? rtrim($_GET['path'], '/') : 'index');
$_index  = explode('/', $_path);

try {

    # Create Controller & Theme Objects
    $_controller = new Controller($_config, $_path, $_index);
    $_theme = new Theme($_config, $_path, $_index);

    # Include functions, classes & plugins
    require_once ROOT_DIR . '/_includes/core/includes.php';

    # Load Controller file
    require $_controller->load($_path);

    # Render the Page
    $_theme->render($_theme->load($_path), get());

} catch (Exception $e) {

    # Show errors on screen for development
    # environment.
    if ( $_config['environment'] == 'dev' ) {
        echo '<div style="background-color: #f7f3d8; padding: 8px; font-family: sans-serif; font-size: 14px; text-align: center;"><img src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/png/512/alert-circled.png" style="vertical-align: middle; margin-right: 4px;" width="16px" height="16px"><strong>Error: </strong>' . $e->getMessage() . '</div>';
    }

}
