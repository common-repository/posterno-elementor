<?php
/**
 * Register custom theme locations for Elementor Pro.
 *
 * @package     posterno-elementor
 * @copyright   Copyright (c) 2020, Sematico, LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Register custom theme locations for the listings dashboard page.
 *
 * @param object $manager elementor manager.
 * @return void
 */
function pno_elementor_dashboard_locations( $manager ) {

	$dashboard_sections = wp_list_pluck( pno_get_dashboard_navigation_items(), 'name' );

	foreach ( $dashboard_sections as $section_key => $section_name ) {

		if ( $section_key === 'logout' ) {
			continue;
		}

		$manager->register_location(
			"dashboard-before-{$section_key}",
			array(
				'label' => sprintf( esc_html__( 'Listings dashboard page: %s (before)', 'posterno-elementor' ), $section_name ),
			)
		);

		$manager->register_location(
			"dashboard-after-{$section_key}",
			array(
				'label' => sprintf( esc_html__( 'Listings dashboard page: %s (after)', 'posterno-elementor' ), $section_name ),
			)
		);

	}

}
add_action( 'elementor/theme/register_locations', 'pno_elementor_dashboard_locations' );

/**
 * Registers custom listing card sections for the elementor theme builder.
 *
 * @param object $manager elementor manager.
 * @return void
 */
function pno_elementor_cards_layout_locations( $manager ) {

	$manager->register_location(
		'listing-card',
		array(
			'label' => esc_html__( 'Listing card', 'posterno-elementor' ),
		)
	);

}
add_action( 'elementor/theme/register_locations', 'pno_elementor_cards_layout_locations' );
