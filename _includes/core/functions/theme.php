<?php

/**
 * Get Partial
 * Get and render a partial template file.
 *
 * @since 1.0.0
 *
 * $part: (string) name of the partial, relative to
 * the _templates/partials directory.
 */
function get_partial( $part ) {

    # Get theme object
    global $_theme;
    return $_theme->get_partial($part);

}

/**
 * Get Header
 * Get header partial.
 *
 * @since 1.0.0
 *
 * $name: (string) name of custom header file.
 */
function get_header( $name = 'header' ) {
    return get_partial($name);
}

/**
 * Get Footer
 * Get footer partial.
 *
 * @since 1.0.0
 *
 * $name: (string) name of custom footer file.
 */
function get_footer( $name = 'footer' ) {
    return get_partial($name);
}

/**
 * Get Sidebar
 * Get sidebar partial.
 *
 * @since 1.0.0
 *
 * $name: (string) name of custom sidebar file.
 */
function get_sidebar( $name = 'sidebar' ) {
    return get_partial($name);
}

/**
 * Assets Dir
 * Return location of assets relative to
 * the ROOT_DIR.
 *
 * @since 1.0.1
 *
 * $prefix: (string) string to prepend to the returned value.
 * $print: (bool) print the value to the screen
 */
function assets_dir( $prefix = '/', $print = true ) {

    # Get Theme
    global $_theme;

    # Get Current Theme Location
    $location = $_theme->prop('dir');

    if ( $print === true ) {
        echo $prefix . $location . '/assets';
    } else {
        return $prefix . $location . '/assets';
    }

}

/**
 * Use Theme
 *
 * @since 1.5.1
 *
 * @global $_theme
 * @param $theme (string) Directory of theme to use
 * @return void
 */
function use_theme( $theme ) {
    global $_theme;
    return $_theme->use_theme($theme);
}

/**
 * Add asset
 *
 * @since 1.4.0
 *
 * @param $type (string) asset type (stylesheet or script)
 * @param $id (string) Unique ID for this asset
 * @param $location (string) asset or array of assets to add
 * @param $paths (array) (optional) Array of pages to add this to. Will add to all otherwise.
 */
function add_asset( $type, $id, $location, $paths = false ) {

    # Validate $type
    if ( $type !== 'stylesheet' && $type !== 'script' ) {
        throw new Exception(sprintf(
            '<code>%s</code> is not a valid asset type.',
            $type
        ));
    }

    # Set Page Asset
    if ( is_array($paths) ) {

        # Get current path
        $path = get('page.path');

        # If path is in paths, add stylesheet
        if ( in_array( $path, $paths ) ) {

            # Get existing assets
            $assets = get('page.'. $type .'s');

            # Check $assets is an array
            if ( !is_array($assets) ) {
                $assets = array();
            }

            # Add new asset
            $assets[$id] = $location;

            # Set asset
            set('page.'. $type .'s', $assets);

        }

    # Set Global Asset
    } else {

        # Get existing assets
        $assets = get('site.'. $type .'s');

        # Check $assets is an array
        if ( !is_array($assets) ) {
            $assets = array();
        }

        # Add new asset
        $assets[$id] = $location;

        # Set asset
        set('site.'. $type .'s', $assets);

    }

}

/**
 * Add Stylesheet
 *
 * @since 1.4.0
 *
 * @see add_asset()
 *
 * @param $id (string) Unique ID for this stylesheet
 * @param $location (string) Stylesheet to add
 * @param $paths (array) (optional) Array of pages to add this to. Will add to all otherwise.
 */
function add_stylesheet( $id, $location, $paths = false ) {
    add_asset( 'stylesheet', $id, $location, $paths );
}

/**
 * Add Script
 *
 * @since 1.4.0
 *
 * @see add_asset()
 *
 * @param $id (string) Unique ID for this script
 * @param $location (string) Script to add
 * @param $paths (array) (optional) Array of paths to add this to. Will add to all otherwise.
 */
function add_script( $id, $location, $paths = false ) {
    add_asset( 'script', $id, $location, $paths );
}

/**
 * Remove Asset
 *
 * @since 1.4.0
 *
 * @param $type (string) Asset type (stylesheet or script)
 * @param $id (string) ID of the asset to remove
 * @param $paths (array) (optional) Paths to remove this asset from
 *
 * @NOTE For older config files, assets do not have IDs so
 * to remove an asset you'll need to use it's numeric key.
 * Starting from 0 up to however many assets there are.
 */
function remove_asset( $type, $id, $paths = false ) {

    # Validate $type
    if ( $type !== 'stylesheet' && $type !== 'script' ) {
        throw new Exception(sprintf(
            '<code>%s</code> is not a valid asset type.',
            $type
        ));
    }

    # Remove path specific assets
    if ( is_array($paths) ) {

        # Get Path
        $path = get('page.path');

        # Remove asset
        if ( in_array($path, $paths) ) {

            # Get assets
            $assets = get('page.'. $type .'s');

            # Check asset exists
            if ( !array_key_exists($id, $assets) ) {
                return false;
            }

            # Remove the assets
            unset($assets[$id]);

            # Reset assets
            set('page.'. $type .'s', $assets);

        }

    } else {

        # Get assets
        $assets = get('site.'. $type .'s');

        # Check asset exists
        if ( !array_key_exists($id, $assets) ) {
            return false;
        }

        # Remove the assets
        unset($assets[$id]);

        # Reset assets
        set('site.'. $type .'s', $assets);

    }

}

/**
 * Remove Stylesheet
 *
 * @since 1.4.0
 *
 * @see remove_asset()
 *
 * @param $id (string) ID of the stylesheet to remove
 * @param $paths (array) (optional) Paths to remove this stylesheet from
 */
function remove_stylesheet( $id, $paths = false ) {
    remove_asset( 'stylesheet', $id, $paths );
}

/**
 * Remove Script
 *
 * @since 1.4.0
 *
 * @see remove_asset()
 *
 * @param $id (string) ID of the script to remove
 * @param $paths (array) (optional) Paths to remove this script from
 */
function remove_script( $id, $paths = false ) {
    remove_asset( 'script', $id, $paths );
}
