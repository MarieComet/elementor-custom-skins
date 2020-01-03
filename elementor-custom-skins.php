<?php
/**
 * Plugin Name: Elementor custom skins
 * Description: Add some custom skins to Elementor widgets
 * Plugin URI:
 * Author: Marie Comet
 * Version: 0.0.1
 * Author URI: https://mariecomet.fr
 *
 * Text Domain: elementor-custom-skins
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ELEMENTOR_CUSTOM_SKINS__FILE__', __FILE__ );

/**
 * Main Elementor Elementor Custom Skins Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 0.0.1
 */
final class MC_Elementor_Custom_Skins {

    /**
     * Plugin Version
     *
     * @since 0.0.1
     *
     * @var string The plugin version.
     */
    const VERSION = '0.0.1';

    /**
     * Minimum Elementor Version
     *
     * @since 0.0.1
     *
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @since 0.0.1
     *
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     *
     * @since 0.0.1
     *
     * @access private
     * @static
     *
     * @var MC_Elementor_Custom_Skins The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 0.0.1
     *
     * @access public
     * @static
     *
     * @return MC_Elementor_Custom_Skins An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    /**
     * Constructor
     *
     * @since 0.0.1
     *
     * @access public
     */
    public function __construct() {

        // Load translation
        add_action( 'init', array( $this, 'i18n' ) );
        // Init Plugin
        add_action( 'plugins_loaded', array( $this, 'init' ) );

    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     *
     * Fired by `init` action hook.
     *
     * @since 0.0.1
     *
     * @access public
     */
    public function i18n() {

        load_plugin_textdomain( 'elementor-custom-skins' );

    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed load the files required to run the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 0.0.1
     *
     * @access public
     */
    public function init() {

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Once we get here, We have passed all validation checks so we can safely include our plugin
        require_once( 'plugin.php' );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 0.0.1
     *
     * @access public
     */
    public function admin_notice_missing_main_plugin() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-custom-skins' ),
            '<strong>' . esc_html__( 'Elementor Custom Skins', 'elementor-custom-skins' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'elementor-custom-skins' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 0.0.1
     *
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-custom-skins' ),
            '<strong>' . esc_html__( 'Elementor Custom Skins', 'elementor-custom-skins' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'elementor-custom-skins' ) . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 0.0.1
     *
     * @access public
     */
    public function admin_notice_minimum_php_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-custom-skins' ),
            '<strong>' . esc_html__( 'Elementor Custom Skins', 'elementor-custom-skins' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'elementor-custom-skins' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }
}

MC_Elementor_Custom_Skins::instance();
