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

					echo $ui->get_tr_start() . $ui->get_th_start() . $ui->get_th_end() . $ui->get_td_start();

					echo $ui->get_fieldset_start();

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_post_type_caps',
						'name'      => 'edit_post',
						'textvalue' => ( isset( $current['edit_post'] ) ) ? esc_attr( $current['edit_post'] ) : '',
						'labeltext' => esc_html__( '"Edit Post" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "edit_post".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_post_type_caps',
						'name'      => 'read_post',
						'textvalue' => ( isset( $current['read_post'] ) ) ? esc_attr( $current['read_post'] ) : '',
						'labeltext' => esc_html__( '"Read Post" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "read_post".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_post_type_caps',
						'name'      => 'delete_post',
						'textvalue' => ( isset( $current['delete_post'] ) ) ? esc_attr( $current['delete_post'] ) : '',
						'labeltext' => esc_html__( '"Delete Post" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "delete_post".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_post_type_caps',
						'name'      => 'edit_posts',
						'textvalue' => ( isset( $current['edit_posts'] ) ) ? esc_attr( $current['edit_posts'] ) : '',
						'labeltext' => esc_html__( '"Edit Posts" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "edit_posts".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_post_type_caps',
						'name'      => 'edit_others_posts',
						'textvalue' => ( isset( $current['edit_others_posts'] ) ) ? esc_attr( $current['edit_others_posts'] ) : '',
						'labeltext' => esc_html__( '"Edit Others Posts" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "edit_others_posts".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_post_type_caps',
						'name'      => 'publish_posts',
						'textvalue' => ( isset( $current['publish_posts'] ) ) ? esc_attr( $current['publish_posts'] ) : '',
						'labeltext' => esc_html__( '"Publish Posts" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "publish_posts".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_post_type_caps',
						'name'      => 'read_private_posts',
						'textvalue' => ( isset( $current['read_private_posts'] ) ) ? esc_attr( $current['read_private_posts'] ) : '',
						'labeltext' => esc_html__( '"Read Private Posts" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "read_private_posts".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_fieldset_end();

					echo $ui->get_td_end() . $ui->get_tr_end();

					$select = array(
						'options' => array(
							array( 'attr' => '0', 'text' => esc_attr__( 'False', 'custom-post-type-ui-capabilities' ) ),
							array( 'attr' => '1', 'text' => esc_attr__( 'True', 'custom-post-type-ui-capabilities' ), 'default' => 'true' ),
						),
					);
					$selected = ( isset( $current ) ) ? disp_boolean( $current['map_meta_cap'] ) : '';
					$select['selected'] = ( ! empty( $selected ) ) ? $current['map_meta_cap'] : '';
					echo $ui->get_select_input( array(
						'namearray'  => 'cpt_custom_post_type_caps',
						'name'       => 'map_meta_cap',
						'labeltext'  => esc_html__( 'Map Meta Cap Value', 'custom-post-type-ui-capabilities' ),
						'aftertext'  => esc_html__( '(CPTUI default: true) Sets the map_meta_cap value for this post type.', 'custom-post-type-ui-capabilities' ),
						'selections' => $select,
					) );
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
    $cpt_capabilities_data = $data['cpt_custom_post_type_caps'];

    $cptuic_settings = get_post_type_capabilities_data();

    $cptuic_settings[ $cpt_slug ] = $cpt_capabilities_data;

	set_post_type_capabilities_data( $cptuic_settings );
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
    $cptuic_settings = get_post_type_capabilities_data();
    if ( empty( $cptuic_settings ) ) {
        return $args;
    }

    $post_type = $cptuic_settings[ $post_type_slug ];
    if ( ! empty( $post_type ) && is_array( $post_type ) ) {
		foreach ( $post_type as $cap_slug => $custom_value ) {
			if ( 'map_meta_cap' === $cap_slug ) {
				$args['map_meta_cap'] = \get_disp_boolean( $custom_value );
				continue;
			}
			if ( ! empty( $custom_value ) ) {
				$args['capabilities'][ $cap_slug ] = $custom_value;
			}
		}
    }

	return $args;
}
add_filter( 'cptui_pre_register_post_type', __NAMESPACE__ . '\filter_post_type_arguments', 10, 3 );
