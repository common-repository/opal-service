<?php
/**
 * @package opalservice
 * @category Plugins
 * @author WPOPAL
 * |--------------------------------------------------------------------------
 * | Plugin Opal Service
 * |--------------------------------------------------------------------------
 * Plugin Name: Opal Service
 * Plugin URI: http://www.wpopal.com/opalservice/
 * Description: Create and maintain modern online menus for almost any kind of service.
 * Version: 1.9.1
 * Update: 06/02/2023
 * Author: WPOPAL
 * Author URI: http://www.wpopal.com
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

if (!class_exists("OpalService")):
    /**
     * Main OpalService Class
     * @since 1.0
     */
    final class OpalService {
        /**
         * @var Opalservice The one true Opalservice
         * @since 1.0
         */
        private static $instance;

        /**
         * Plugin path
         *
         * @var string
         */
        protected $_plugin_path = null;

        /**
         * contructor
         */
        public function __construct() {
            //add_action('elementor/widgets/widgets_registered', array($this, 'include_widgets'));
        }

        /**
         * Main Opalservice Instance
         *
         * Insures that only one instance of Opalservice exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         *
         * @return    Opalservice
         * @uses      Opalservice::setup_constants() Setup the constants needed
         * @uses      Opalservice::includes() Include the required files
         * @uses      Opalservice::load_textdomain() load the language files
         * @see       Opalservice()
         * @since     1.0
         * @static
         * @staticvar array $instance
         */
        public static function getInstance() {

            if (!isset(self::$instance) && !(self::$instance instanceof OpalService)) {
                self::$instance = new OpalService;
                self::$instance->setup_constants();

                add_action('plugins_loaded', array(self::$instance, 'load_textdomain'));
                add_action('elementor/widgets/register', array(self::$instance, 'osv_load_elementor_widgets'));
                self::$instance->includes();
                //self::$instance->roles  = new Opalservice_Roles();
            }
            //update_option( 'opalservice_setup', '' );
            //add_action("admin_print_footer_scripts", array( self::$instance, 'shortcode_button_script'));
            return self::$instance;
        }

        /**
         * Function Defien
         */
        public function setup_constants() {
            define("OPALSERVICE_VERSION", "1.0.0");
            define("OPALSERVICE_MINIMUM_WP_VERSION", "4.0");
            define("OPALSERVICE_PLUGIN_URL", plugin_dir_url(__FILE__));
            define("OPALSERVICE_PLUGIN_DIR", plugin_dir_path(__FILE__));
            define('OPALSERVICE_MEDIA_URL', plugins_url(plugin_basename(__DIR__) . '/assets/'));
            define('OPALSERVICE_LANGUAGE_DIR', plugin_dir_path(__FILE__) . '/languages/');
            define('OPALSERVICE_THEMER_TEMPLATES_DIR', get_template_directory() . '/');
            define('OPALSERVICE_THEMER_TEMPLATES_URL', get_bloginfo('template_url') . '/');

        }

        /**
         * Throw error on object clone
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object, therefore we don't want the object to be cloned.
         *
         * @return void
         * @since  1.0
         * @access protected
         */
        public function __clone() {
            // Cloning instances of the class is forbidden
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'opal-service'), '1.0');
        }

        /**
         * Include a file
         *
         * @param string
         * @param bool
         * @param array
         */
        function _include($file, $root = true, $args = array(), $unique = true) {
            if ($root) {
                $file = $this->plugin_path($file);
            }
            if (is_array($args)) {
                extract($args);
            }

            if (file_exists($file)) {
                if ($unique) {
                    require_once $file;
                } else {
                    require $file;
                }
            }
        }

        /**
         * Get the path of the plugin with sub path
         *
         * @param string $sub
         * @return string
         */
        function plugin_path($sub = '') {
            if (!$this->_plugin_path) {
                $this->_plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            }
            return $this->_plugin_path . '/' . $sub;
        }

        public function includes() {

            global $opalservice_options;

            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            // CMB2
            if (!is_plugin_active('cmb2/init.php')) {
                require_once OPALSERVICE_PLUGIN_DIR . 'inc/vendors/cmb2/libraries/init.php';
            }
            $this->_include('inc/vendors/cmb2/custom-fields/fontpicker.php');

            //-- include admin setting
            $this->_include('inc/admin/register-settings.php');
            $opalservice_options = opalservice_get_settings();
            //-- include teamplate loader
            $this->_include('inc/class-template-loader.php');
            //--
            $this->_include("inc/mixes-functions.php");
            //--
            $this->_include("inc/ajax-functions.php");

            $this->_include('inc/class-opalservice-query.php');

            //-- include all file *.php in directories , call function in inc/mixes-functions.php
            opalservice_includes(OPALSERVICE_PLUGIN_DIR . 'inc/post-types/*.php');
            opalservice_includes(OPALSERVICE_PLUGIN_DIR . 'inc/taxonomies/*.php');
            $this->_include("inc/vendors/taxonomy_image.php");
            //--
            $this->_include("inc/template-functions.php");
            //--

            //--
            $this->_include("inc/class-opalservice-service.php"); //***
            //--
            $this->_include('inc/class-opalservice-scripts.php');
            //--
            $this->_include("inc/class-opalservice-shortcodes.php");

            // Customizer
            $this->_include("inc/class-opalservice-customizer.php");

            // Widgets
            $this->_include("inc/class-opalservice-widgets.php");

            if (class_exists("KingComposer")) {
                //--
                $this->_include("inc/vendors/kingcomposer.php"); //**
                //--
            }

            if (class_exists("Vc_Manager")) {
                require OPALSERVICE_PLUGIN_DIR . 'inc/vendors/visualcomposer/class-vc-elements.php';
                require OPALSERVICE_PLUGIN_DIR . 'inc/vendors/visualcomposer.php';
            }


            $this->_include('install.php');
            //--
            if (get_option('opalservice_setup', false) != 'installed') {
                register_activation_hook(__FILE__, 'opalservice_install');
                update_option('opalservice_setup', 'installed');
            }
            $this->_include('uninstall.php');
            // uninstall
            register_uninstall_hook(__FILE__, 'opalservice_uninstall');
            //--
            // // add widgets
            add_action('widgets_init', array($this, 'widgets_init'));
        }

        /**
         * this is function Load all Widgets
         */
        public function widgets_init() {
            opalservice_includes(OPALSERVICE_PLUGIN_DIR . 'inc/widgets/*.php');

        }

        /**
         * Automatic load widget files in elementor folder, show warning if not exists
         *
         * @return avoid
         * @var Object $widgets_manager
         */
        public function osv_load_elementor_widgets($widgets_manager) {

            $files = glob(OPALSERVICE_PLUGIN_DIR . "inc/vendors/elementor/*.php");

            if ($files) {
                foreach ($files as $file) {
                    $class = "OSV_Elementor_Widget_" . ucfirst(basename(str_replace('.php', '', $file)));
                    require_once($file);
                    if (class_exists($class)) {
                        $widgets_manager->register(new $class());
                    }
                }
            }
        }


        /**
         * Loads the plugin language files
         *
         * @access public
         * @return void
         * @since  1.0
         */

        public function load_textdomain() {
            $lang_dir      = dirname(plugin_basename(__FILE__)) . '/languages/';
            $lang_dir      = apply_filters('opalservice_languages_directory', $lang_dir);
            $locale        = apply_filters('plugin_locale', get_locale(), 'opal-service');
            $mofile        = sprintf('%1$s-%2$s.mo', 'opal-service', $locale);
            $mofile_local  = $lang_dir . $mofile;
            $mofile_global = WP_LANG_DIR . '/opal-service/' . $mofile;

            if (file_exists($mofile_global)) {
                load_textdomain('opal-service', $mofile_global);
            } else {
                if (file_exists($mofile_local)) {
                    load_textdomain('opal-service', $mofile_local);
                } else {
                    load_plugin_textdomain('opal-service', false, $lang_dir);
                }
            }
        }

    }// end Class Root
endif; // End if class_exists check

/**
 * The main function responsible for returning the one true Opalservice
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $dpemployee = Opalservice(); ?>
 *
 * @return object - The one true Opalservice Instance
 * @since 1.0
 */
function Opalservice() {
    return OpalService::getInstance();
}

// Get Opalservice Running
Opalservice();

