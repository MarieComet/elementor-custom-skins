<?php
namespace MC_Custom_Skins;

use MC_Custom_Skins\Posts\Skin_Slide;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Plugin {

  /**
   * Instance
   *
   * @since 1.2.0
   * @access private
   * @static
   *
   * @var Plugin The single instance of the class.
   */
  private static $_instance = null;
  /**
   * Instance
   *
   * Ensures only one instance of the class is loaded or can be loaded.
   *
   * @since 1.2.0
   * @access public
   *
   * @return Plugin An instance of the class.
   */
  public static function instance() {
      if ( is_null( self::$_instance ) ) {
          self::$_instance = new self();
      }
      return self::$_instance;
  }

  /**
   * widget_scripts
   *
   * Load required plugin core files.
   *
   * @since 1.2.0
   * @access public
   */
  public function widget_scripts() {
      //wp_register_script( 'button-fixed-js', plugins_url( '/assets/js/button-fixed.js', __FILE__ ), [ 'jquery' ], false, true );
      
  }

  /**
   *  widgets styles
   *
   * Load widgets styles
   *
  */
  public function widget_styles() { 

      wp_enqueue_style( 'elementor-custom-skins', plugins_url( 'assets/css/elementor-custom-skins.css', __FILE__ ) );

  }

  /**
   * Include Widgets files
   *
   * Load widgets files
   *
   * @since 1.2.0
   * @access private
   */
  private function include_skins_files() {
      require_once( __DIR__ . '/skins/posts/skin-slide.php' );
      //require_once( __DIR__ . '/widgets/inline-editing.php' );
  }
  /**
   * Register Widgets
   *
   * Register new Elementor widgets.
   *
   * @since 1.2.0
   * @access public
   */
  public function register_widgets() {
      // Its is now safe to include Widgets files
      $this->include_skins_files();
      // Register skin
      add_action( 'elementor/widget/posts/skins_init', function( $widget ) {
         $widget->add_skin( new Posts\Skin_Slide($widget) );
      } );
  }

  /**
   *  Plugin class constructor
   *
   * Register plugin action hooks and filters
   *
   * @since 1.2.0
   * @access public
   */
  public function __construct() {
      // Register widget scripts
      //add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

      add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
      // Register widgets
      add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
  }
}
new Plugin();
