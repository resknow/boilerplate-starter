<?php

/**
 * Plugin Dir
 * Returns plugin directory path
 *
 * @since 1.0.0
 */
function plugin_dir() {
    return ROOT_DIR . '/_plugins';
}

/**
 * Plugin Exists
 *
 * @since 1.0.0
 *
 * $plugin: (string) name of the plugin to check
 */
function plugin_exists( $plugin ) {
    return is_dir(plugin_dir() .'/'. $plugin);
}

/**
 * Plugin Is Active
 *
 * @since 1.0.0
 *
 * $plugin: (string) name of the plugin to check
 */
function plugin_is_active( $plugin ) {
    return file_exists(plugin_dir() .'/'. $plugin .'/plugin.php');
}

/**
 * Plugin Load Config
 * Load a plugins' YAML config file.
 *
 * @since 1.0.0
 *
 * @param $plugin: (string) name of the plugin to load
 */
function plugin_load_config( $plugin ) {
    $config = Spyc::YAMLLoad(ROOT_DIR . '/_plugins/' . $plugin . '/.config.yml');

    if ( extras_enabled() ) {
        $config = apply_filters($plugin . '_load_config', $config);
    }

    return $config;
}

/**
 * Plugin Requires Version
 *
 * @since 1.4.0
 *
 * @param $plugin (string) Plugin slug/name
 * @param $version (string|float) Minimum version number required
 */
function plugin_requires_version( $plugin, $version ) {
    $bp = bp_version();

    if ( $bp < $version ) {
        throw new Exception(sprintf(
            '%s requires at least Boilerplate version %s.',
            $plugin,
            (string)$version
        ));
    }
}

/**
 * Plugin is Compatible
 *
 * @since 1.4.0
 *
 * @param $plugin (string) Plugin slug/name
 * @param $min_version (string|float) Minimum compatible version
 * @param $max_version (string|float) Maximum compatible version
 */
function plugin_is_compatible( $plugin, $min_version, $max_version ) {
    $bp = bp_version();

    if ( $bp < $min_version || $bp > $max_version ) {
        throw new Exception(sprintf(
            '%s is not compatible with this version of Boilerplate (%s). Minimum version: %s. Maximum version: %s',
            $plugin,
            $bp,
            (string)$min_version,
            (string)$max_version
        ));
    }
}
