<?php
/**
 * Custom Post Type UI Capabilities Hook Callbacks
 *
 * @since 1.0.0
 *
 * @package custom-post-type-ui-capabilities
 * @subpackage hook-callbacks
 */

namespace tw2113\cptuic;

/**
 * Add post type capabilities options to CPTUI screen.
 *
 * @since 1.0.0
 *
 * @internal
 * @param object|string $ui A cptui_admin_ui instance.
 */
function add_post_type_capabilities_ui( $ui = '' ) {

	$tab = ( ! empty( $_GET ) && ! empty( $_GET['action'] ) && 'edit' === $_GET['action'] ) ? 'edit' : 'new';

	if ( 'edit' === $tab ) {
		$post_types         = get_post_type_capabilities_data();
		$selected_post_type = \cptui_get_current_post_type();

		if ( $selected_post_type ) {
			if ( array_key_exists( $selected_post_type, $post_types ) ) {
				$current = $post_types[ $selected_post_type ];
			}
		}
	} ?>
	<div class="cptuic-section postbox">
		<button type="button" class="handlediv button-link" aria-expanded="true">
			<span class="screen-reader-text" ><?php esc_html_e( 'Toggle panel: Post Type Capabilities', 'cptuiext' ); ?></span>
			<span class="toggle-indicator" aria-hidden="true"></span>
		</button>
		<h2 class="hndle">
			<span><?php esc_html_e( 'Post Type Capabilities', 'cptuiext' ); ?></span>
		</h2>
		<div class="inside">
			<div class="main">
				<table class="form-table cptui-table">
					<?php

					echo $ui->get_tr_start() . $ui->get_th_start() . __( 'Add to default category archive', 'cptuiext' ) . $ui->get_th_end() . $ui->get_td_start();
					echo $ui->get_check_input( array(
						'checkvalue' => '1',
						'checked'    => ( isset( $current['cpt_to_category_archive'] ) ) ? 'true' : 'false',
						'name'       => 'cptuic_capabilities',
						'namearray'  => 'cptuic_capabilities',
						'textvalue'  => '1',
						'labeltext'  => esc_html__( 'Add the post entries from this post type to the default category archive.', 'cptuiext' ),
						'helptext'   => esc_attr__( 'Add the post entries from this post type to the default category archive.', 'cptuiext' ),
						'default'    => true,
						'wrap'       => false,
					) );
					echo $ui->get_td_end() . $ui->get_tr_end();
					?>
				</table>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'cptui_post_type_after_fieldsets', __NAMESPACE__ . '\add_post_type_capabilities_ui', 9, 1 );

/**
 * Save our capabilities data.
 *
 * @since 1.0.0
 *
 * @param array $data Array of data to pluck capabilities from to save.
 */
function save_post_type_capabilities( array $data ) {

    $cpt_slug = $data['cpt_custom_post_type']['name'];
    $cpt_capabilities_data = $data['cptuic_capabilities'];

    $cptuic_settings = get_option( 'cptui_post_type_capabilities', array() );

    $cptuic_settings[ $cpt_slug ] = 'whatever';

    update_option( 'cptui_post_type_capabilities', $cptuic_settings );
}
add_action( 'cptui_after_update_post_type', __NAMESPACE__ . '\save_post_type_capabilities' );

/**
 * Inject our capabilities arguments into the registration of the post type.
 *
 * @since 1.0.0
 *
 * @param array $args     Array of args for the currently registering post type.
 * @param $post_type_slug Current post type slug being registered.
 * @param $post_type_data Current post type data from CPTUI.
 * @return mixed
 */
function filter_post_type_arguments( $args, $post_type_slug, $post_type_data ) {
    $cptui_settings = get_option( 'cptui_post_type_capabilities', array() );

    $post_type = $cptui_settings[ $post_type_slug ];


}
add_filter( 'cptui_pre_register_post_type', __NAMESPACE__ . '\filter_post_type_arguments', 10, 3 );
