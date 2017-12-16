<?php
/**
 * Custom Post Type UI Capabilities
 *
 * @since 1.0.0
 *
 * @package custom-post-type-ui-capabilities
 */

/*
 * Plugin Name: Custom Post Type UI Capabilities
 * Plugin URI: https://github.com/tw2113/custom-post-type-ui-capabilities
 * Description: Adds capabilities support for Custom Post Type UI
 * Author: tw2113
 * Version: 1.0.0
 * Author URI: https://michaelbox.net
 * Text Domain: custom-post-type-ui-capabilities
 * Domain Path: /languages
 * License: GPL-2.0+
 */

namespace tw2113\cptuic;

class customPostTypeUICapabilities {

	/**
	 * Current version.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * Plugin basename.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $basename = '';

	/**
	 * URL of plugin directory.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $url = '';

	/**
	 * Path of plugin directory.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $path = '';

	/**
	 * customPostTypeUICapabilities constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->basename    = plugin_basename( __FILE__ );
		$this->url         = plugin_dir_url( __FILE__ );
		$this->path        = plugin_dir_path( __FILE__ );
	}

	/**
	 * Run our hooks to execute the plugin.
	 *
	 * @since 1.0.0
	 */
	public function do_hooks() {

		if ( ! $this->meets_requirements() ) {
			add_action( 'admin_notices', array( $this, 'requirements_not_met_notice' ) );
			return;
		}

		add_action( 'cptui_loaded', array( $this, 'includes' ) );
	}

	/**
	 * Include extra files.
	 *
	 * @since 1.0.0
	 */
	public function includes() {
		include $this->path . 'inc/post-type-hooks.php';
		include $this->path . 'inc/taxonomy-hooks.php';
		include $this->path . 'inc/helpers.php';
	}

	/**
	 * Check that all plugin requirements are met
	 *
	 * @since  1.0.0
	 *
	 * @return boolean $value True if requirements are met.
	 */
	public static function meets_requirements() {

		// Do checks for required classes / functions.
		if ( ! function_exists( 'cptui_create_custom_post_types' ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met.
	 *
	 * @since 1.0.0
	 */
	public function requirements_not_met_notice() {
		// Output our error.
		$error_text = esc_html__( 'Custom Post Type UI Capabilities requires Custom Post Type UI to be active. Please make sure that requirement is met to activate Custom Post Type UI Capabilities.', 'custom-post-type-ui-capabilities' );

		echo '<div id="message" class="error">';
		echo '<p>' . esc_attr( $error_text ) . '</p>';
		echo '</div>';
	}
}

function load() {
	$cptuic = new customPostTypeUICapabilities();
	$cptuic->do_hooks();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\load', 8 );
