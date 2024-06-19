<?php
/*
Plugin Name: ZeroHex
Description: Ein Elementor-Plugin, das Hexagon-Platzhalter erstellt.
Version: 1.0.0
Author: Roland Zechner
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class ElementorHexagonPlaceholder {

  const VERSION = '1.0.0';

  const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

  const MINIMUM_PHP_VERSION = '7.0';

  public function __construct() {
      add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
  }

  public function on_plugins_loaded() {
      if ( $this->is_compatible() ) {
          add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
      }
  }

  public function is_compatible() {
      if ( ! did_action( 'elementor/loaded' ) ) {
          add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
          return false;
      }

      if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
          add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
          return false;
      }

      if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
          add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
          return false;
      }

      return true;
  }

  public function register_widgets() {
    require_once( 'widgets/hexagon-placeholder.php' );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Hexagon_Placeholder_Widget() );

    require_once( 'widgets/hexagon-container.php' );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new HexagonContainerWidget() );
}
}

new ElementorHexagonPlaceholder();