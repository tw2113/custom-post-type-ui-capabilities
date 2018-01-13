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
 * Add taxonomy capabilities options to CPTUI screen.
 *
 * @since 1.0.0
 *
 * @internal
 * @param object|string $ui A cptui_admin_ui instance.
 */
function add_taxonomy_capabilities_ui( $ui = '' ) {

	$tab = ( ! empty( $_GET ) && ! empty( $_GET['action'] ) && 'edit' === $_GET['action'] ) ? 'edit' : 'new';

	if ( 'edit' === $tab ) {
		$taxonomies        = get_taxonomy_capabilities_data();
		$selected_taxonomy = \cptui_get_current_taxonomy();
		if ( $selected_taxonomy ) {
			if ( array_key_exists( $selected_taxonomy, $taxonomies ) ) {
				$current = $taxonomies[ $selected_taxonomy ];
			}
		}
	} ?>
	<div class="cptuic-section postbox">
		<button type="button" class="handlediv button-link" aria-expanded="true">
			<span class="screen-reader-text" ><?php esc_html_e( 'Toggle panel: Taxonomy Capabilities', 'custom-post-type-ui-capabilities' ); ?></span>
			<span class="toggle-indicator" aria-hidden="true"></span>
		</button>
		<h2 class="hndle">
			<span><?php esc_html_e( 'Taxonomy Capabilities', 'custom-post-type-ui-capabilities' ); ?></span>
		</h2>
		<div class="inside">
			<div class="main">
				<table class="form-table cptui-table">
					<?php

					echo $ui->get_tr_start() . $ui->get_th_start() . $ui->get_th_end() . $ui->get_td_start();
					echo $ui->get_fieldset_start();

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_tax_caps',
						'name'      => 'manage_terms',
						'textvalue' => ( isset( $current['manage_terms'] ) ) ? esc_attr( $current['manage_terms'] ) : '',
						'labeltext' => esc_html__( '"Manage Terms" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "manage_terms".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_tax_caps',
						'name'      => 'edit_terms',
						'textvalue' => ( isset( $current['edit_terms'] ) ) ? esc_attr( $current['edit_terms'] ) : '',
						'labeltext' => esc_html__( '"Edit Terms" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "edit_terms".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_tax_caps',
						'name'      => 'delete_terms',
						'textvalue' => ( isset( $current['delete_terms'] ) ) ? esc_attr( $current['delete_terms'] ) : '',
						'labeltext' => esc_html__( '"Delete Terms" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "delete_terms".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_text_input( array(
						'namearray' => 'cpt_custom_tax_caps',
						'name'      => 'assign_terms',
						'textvalue' => ( isset( $current['assign_terms'] ) ) ? esc_attr( $current['assign_terms'] ) : '',
						'labeltext' => esc_html__( '"Assign Terms" Mapping', 'custom-post-type-ui-capabilities' ),
						'helptext'  => esc_html__( 'Capability to map to "assign_terms".', 'custom-post-type-ui-capabilities' ),
					) );

					echo $ui->get_fieldset_end();
					echo $ui->get_td_end() . $ui->get_tr_end();
					?>
                </table>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'cptui_taxonomy_after_fieldsets', __NAMESPACE__ . '\add_taxonomy_capabilities_ui', 9, 1 );

/**
 * Save our capabilities data.
 *
 * @since 1.0.0
 *
 * @param array $data Array of data to pluck capabilities from to save.
 */
function save_taxonomy_capabilities( array $data ) {

    $cpt_tax_slug = $data['cpt_custom_tax']['name'];
    $cpt_capabilities_data = $data['cpt_custom_tax_caps'];

    $cptuic_settings = get_taxonomy_capabilities_data();

    $cptuic_settings[ $cpt_tax_slug ] = $cpt_capabilities_data;

	set_taxonomy_capabilities_data( $cptuic_settings );
}
add_action( 'cptui_after_update_taxonomy', __NAMESPACE__ . '\save_taxonomy_capabilities' );

/**
 * Inject our capabilities arguments into the registration of the taxonomy.
 *
 * @since 1.0.0
 *
 * @param array $args    Array of args for the currently registering taxonomy.
 * @param $taxonomy_slug Current taxonomy slug being registered.
 * @param $taxonomy_data Current taxonomy data from CPTUI.
 * @return mixed
 */
function filter_taxonomy_arguments( $args, $taxonomy_slug, $taxonomy_data ) {
    $cptuic_settings = get_taxonomy_capabilities_data();
    if ( empty( $cptuic_settings ) ) {
        return $args;
    }

    $taxonomy = $cptuic_settings[ $taxonomy_slug ];
    if ( ! empty( $taxonomy ) && is_array( $taxonomy ) ) {
	    foreach ( $taxonomy as $cap_slug => $custom_value ) {
		    if ( ! empty( $custom_value ) ) {
			    $args['capabilities'][ $cap_slug ] = $custom_value;
		    }
	    }
    }

    return $args;
}
add_filter( 'cptui_pre_register_taxonomy', __NAMESPACE__ . '\filter_taxonomy_arguments', 10, 3 );
