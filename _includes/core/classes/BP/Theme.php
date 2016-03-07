<?php

namespace BP;
use Exception;

class Theme {

    /**
     * Active Theme
     */
    private $active;

    /**
     * Template directory
     */
    private $dir;

    /**
     * Template file extension
     */
    private $ext;

    /**
     * Default file
     * For templates would be a 404
     * or for logic, could be a simple
     * file for setting default
     * code for every page
     */
    private $default;

    /**
     * Not Found
     *
     * True if the default
     * file is loaded
     */
    public $not_found = false;

    /**
     * Current path (URL)
     */
    private $path;

    /**
     * Current path index
     */
    private $index      = array();

    /**
     * Twig
     */
    private $twig;

    /**
     * Twig Status
     */
    private $twig_enabled;

    /**
     * Template cache
     */
    private $cache;

    /**
     * Template variables
     */
    private $variables;

    /**
     * Debug mode
     */
    private $debug = false;

    /**
     * Set defaults
     */
    public function __construct(array $site_config, $path, array $index) {

        # Get Site Config
        $this->site_config = $site_config;

        # Default config
        $this->dir          = (isset($this->site_config['theme']) ? $this->site_config['theme'] : '_templates'); # Template directory
        $this->ext          = '.php'; # Template file extension
        $this->default      = '404'; # Default template name
        $this->twig_enabled = false;

        # Set Active Theme
        #
        # @NOTE: This property will probably be
        # removed in a future version of
        # Boilerplate.
        $this->active       = $this->dir;

        # Set path variables
        $this->path         = $path;
        $this->index        = $index;

        # Check for index template
        if ( !is_readable($this->dir . '/index' . $this->ext ) ) {
            throw new Exception(sprintf(
                'Active theme (<code>%s</code>) does not contain an <code>index%s</code> template. This is required.',
                str_replace(ROOT_DIR, '', $this->dir),
                $this->ext
            ));
        }

        /**
         * If Twig is enabled,
         * initialise it.
         */
        if ( isset($this->site_config['twig']) && $this->site_config['twig']['enabled'] === true ) {

            # Set Twig Config
            $this->ext = (isset($this->site_config['twig']['ext']) ? $this->site_config['twig']['ext'] : '.twig');
            $this->cache = (isset($this->site_config['twig']['cache']) ? $this->site_config['twig']['cache'] : false);
            $this->twig_enabled = true;

            # Initialise Twig
            $this->init();

        }

    }

    /**
     * Init
     */
    private function init() {

        /**
         * Make sure Twig is installed
         *
         * @since 1.0.1
         */
        if ( !class_exists('\Twig_Environment') ) {
            throw new Exception(sprintf(
                'Please install the <a href="%s">Twig</a> package to use Twig templating.', 'https://packagist.org/packages/twig/twig'
            ));
        }

        /**
         * Set Twig filesystem directory
         */
        $loader = new \Twig_Loader_Filesystem($this->dir);

        /**
         * Set default options
         */
        $options = array(
            'cache' => $this->cache,
            'debug' => ($this->site_config['environment'] == 'dev' ? true : false)
        );

        /**
         * Load Twig
         */
        $this->twig = new \Twig_Environment($loader, $options);

    }

    /**
     * Get
     *
     * Returns the value of a theme variable.
     */
    public function __get( $property ) {
        return ( isset($this->variables[$property]) ? $this->variables[$property] : false );
    }

    /**
     * Isset
     *
     * Check if a variable exists
     */
    public function __isset( $property ) {
        return isset($this->variables[$property]);
    }

    /**
     * Get property
     *
     * Returns the value of a property.
     *
     * @since 1.0.2
     */
    public function prop( $property ) {
        return ( property_exists( $this, $property ) ? $this->$property : false );
    }

    /**
     * Set property
     */
    public function __set( $property, $value ) {
        $this->$property = $value;
    }

    /**
     * Render
     *
     * @version 1.0.2
     * @since 1.0.0
     */
    public function render( $template, array $variables, $print = true ) {

        /**
         * Store variables in object
         * for reference if needed
         */
        $this->variables = $variables;

        if ( $this->twig_enabled === true ) {

            /**
             * Add debug extension
             *
             * Debug also clears the cache
             * on each page load.
             */
            if ( $this->debug === true ) {
                $this->twig->addExtension(new \Twig_Extension_Debug());

                if ( $this->cache != false ) {
                    $this->clear_cache();
                }
            }

            # Get Page Data (Front Matter)
            $this->get_front_matter($template);

            # Render the page!
            if ( $print === true ) {
                echo $this->twig->render($template, $this->variables);
            } else {
                return $this->twig->render($template, $this->variables);
            }

        } else {

            # Start Output Buffering
            ob_start();

            # Trigger: before_render_template
            do_trigger('before_render_template');

            # Include Template File
            include $this->dir . '/' . $template;

            # Trigger: after_render_template
            do_trigger('after_render_template');

            # Render Output
            if ( $print === true ) {
                echo ob_get_clean();
            } else {
                return ob_get_clean();
            }

        }

    }

    /**
     * Load Template
     */
    public function load( $name, $file = false ) {

        /**
         * Find required template
         */
        switch (true) {

            /**
             * If specific file is
             * entered, attempt
             * to load it.
             */
            case $file !== false && file_exists($this->dir .'/'. $file):
                $template = $file;
            break;

            /**
             * If template with
             * specified name exists,
             * attempt to load it.
             */
            case $file === false && file_exists($this->dir .'/'. $name . $this->ext):
                $template = $name . $this->ext;
            break;

            /**
             * If we find an index.php
             * in a sub folder, load it.
             */
            case $file === false && file_exists($this->dir .'/'. $name .'/index'. $this->ext):
                $template = $name .'/index'. $this->ext;
            break;

            /**
             * If template
             * where dashes replace
             * slashes exists, attempt
             * to load it.
             */
            case $file === false && file_exists($this->dir .'/'. str_replace('/', '-', $name) . $this->ext):
                $template = str_replace('/', '-', $name) . $this->ext;
            break;

            /**
             * Look for parent
             * templates in real
             * folders
             */
            case $file === false && !file_exists($this->dir .'/'. $name . $this->ext):
                $template = $this->find_template();
            break;

            /**
             * Finally, look for
             * parent templates
             * within naming convention
             *
             * e.g.: find-this-file.php
             */
            case $file === false && !file_exists($this->dir .'/'. str_replace('/', '-', $name) . $this->ext):
                $template = $this->find_template(true);
            break;

        }

        /**
         * Return it
         */
        if ( $template !== false && is_readable($this->dir .'/'. $template) ) {
            return $template;
        }

    }

    /**
     * Clear Cache
     *
     * CAUTION: I recommend you
     * you never pass an argument
     * into this method.
     *
     * It WILL delete files without
     * warning and it intended
     * ONLY for clearing the template
     * cache.
     */
    public function clear_cache( $dir = false ) {

        if ( $dir === false ) {
            $dir = $this->cache;
        }

        # Check permissions
        if ( $this->cache != false && !is_writeable($dir) ) {
            throw new Exception('Your <code>cache</code> directory is not writeable. <code>Try chmod 775</code>');
        }

        # Get Cache files
        $files = glob($dir .'/*');

        if ( is_array( $files ) ) {
            foreach ( $files as $file ) {
                if ( is_dir($file) ) {
                    $this->clear_cache($file);
                } else {
                    unlink($file);
                }
            }
        }

        # Trigger: twig_cache_cleared
        do_trigger('twig_cache_cleared');

    }

    /**
     * Find Template
     */
    private function find_template( $replace = false ) {

        $implode = ($replace === false ? '/' : '-');

        $index_count = count($this->index) - 1;
        $index = $this->index;

        while ($index) {

            # Remove last index
            unset($index[$index_count]);

            # Generate filename
            $file = implode($implode, $index) . $this->ext;

            # If we found a match, use it
            if ( file_exists($this->dir .'/'. $file) ) {
                $template = $file;
                break;
            }

            # If not, move on to the next one
            $index_count--;

        }

        # Return template
        if ( isset($template) ) {
            return $template;
        } else {
            $this->not_found = true;
            return $this->default . $this->ext;
        }

    }

    /**
     * Set Debug
     */
    public function set_debug( $status = false ) {
        $this->debug = $status;
    }

    /**
     * Return Not Found status
     */
    public function not_found() {
        return $this->not_found;
    }

    /**
     * Use theme
     *
     * Use specified theme instead
     * of default for this request
     */
    public function use_theme( $theme ) {

        # Update Dir
        $this->dir = $theme;

        # Active Theme
        $this->active = $theme;

        # Re-initialise Twig
        if ( isset($this->site_config['twig']) && $this->site_config['twig']['enabled'] === true ) {
            $this->init();
        }

        # Trigger: theme_changed
        do_trigger('theme_changed', $theme);

    }

    /**
     * Get Front Matter
     */
    public function get_front_matter($template) {

        # Open file
        $raw_template = file_get_contents($this->dir .'/'. $template);

        # Split it down
        $data = explode('--#}', $raw_template);

        # Check if meta is there
        if ( strpos($data[0], '{#--') !== false ) {

            # Save Useful data
            $matter = $data[0];

            # Remove opener
            $matter = str_replace('{#--', '', $matter);

            # Trim First Line
            $matter = ltrim($matter, PHP_EOL);

            # Parse through Spyc
            $page = \Spyc::YAMLLoadString($matter);

            # Filter: front_matter
            $page = apply_filters('front_matter', $page);

            # Return Data
            $this->variables['page'] = array_merge($this->variables['page'], $page);

        } else {
            return;
        }

    }

    /**
     * Get Partial
     *
     * @param $part: (string) name of partial
     */
    public function get_partial( $part ) {

        # Get Partial
        $partial = $this->load('partials/' . $part);

        # Return false if not found
        if ( !is_readable($this->dir . '/' . $partial) ) {
            return false;
        }

        # Trigger: before_include_$part
        do_trigger('before_include_' . $part);

        include $this->dir . '/' . $partial;

        # Trigger: after_include_$part
        do_trigger('after_include_' . $part);

    }

    /**
     * Get Header
     *
     * @param $name: (string) name of header partial
     * @since 1.0.3
     */
    public function get_header( $name = 'header' ) {
        return $this->get_partial($name);
    }

    /**
     * Get Footer
     *
     * @param $name: (string) name of footer partial
     * @since 1.0.3
     */
    public function get_footer( $name = 'footer' ) {
        return $this->get_partial($name);
    }

    /**
     * Get Sidebar
     *
     * @param $name: (string) name of sidebar partial
     * @since 1.0.3
     */
    public function get_sidebar( $name = 'sidebar' ) {
        return $this->get_partial($name);
    }

    /**
     * Assets Dir
     * Return location of assets relative to
     * the ROOT_DIR.
     *
     * @since 1.0.3
     *
     * @param $prefix: (string) string to prepend to the returned value.
     * @param $print: (bool) print the value to the screen
     */
    public function assets_dir( $prefix = '/', $print = true ) {

        # Get Current Theme Location
        $location = $this->prop('dir');

        if ( $print === true ) {
            echo $prefix . $location . '/assets';
        } else {
            return $prefix . $location . '/assets';
        }

    }


}
