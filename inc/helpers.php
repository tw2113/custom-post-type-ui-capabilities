<?php
/**
 * Custom Post Type UI Capabilities Helper Functions
 *
 * @since 1.0.0
 *
 * @package custom-post-type-ui-capabilities
 * @subpackage helpers
 */


namespace tw2113\cptuic;

/**
 * Retrieve our post type capabilities data from our option.
 *
 * @since 1.0.0
 *
 * @return mixed|void
 */
function get_post_type_capabilities_data() {
	return get_option( get_post_type_capabilities_option_key(), array() );
}

/**
 * Update our post type capabilities data to our option.
 *
 * @since 1.0.0
 *
 * @param array $data Array of data to save to our option.
 * @return bool
 */
function set_post_type_capabilities_data( $data ) {
	return update_option( get_post_type_capabilities_option_key(), $data );
}

/**
 * Retrieve our dedicated post type capabilities option name.
 *
 * @since 1.0.0
 *
 * @return string
 */
function get_post_type_capabilities_option_key() {
	return 'cptui_post_type_capabilities';
}

/**
 * Retrieve our taxonomy capabilities data from our option.
 *
 * @since 1.0.0
 *
 * @return mixed|void
 */
function get_taxonomy_capabilities_data() {
	return get_option( get_taxonomy_capabilities_option_key(), array() );
}

/**
 * Update our taxonomy capabilities data to our option.
 *
 * @since 1.0.0
 *
 * @param array $data Array of data to save to our option.
 * @return bool
 */
function set_taxonomy_capabilities_data( $data ) {
	return update_option( get_taxonomy_capabilities_option_key(), $data );
}

/**
 * Retrieve our dedicated taxonomy capabilities option name.
 *
 * @since 1.0.0
 *
 * @return string
 */
function get_taxonomy_capabilities_option_key() {
	return 'cptui_taxonomy_capabilities';
}

