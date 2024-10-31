<?php
/**
 * Elementor pro specific actions.
 *
 * @package     posterno-elementor
 * @copyright   Copyright (c) 2020, Sematico, LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use Posterno\Elementor\Cache;
use Posterno\Elementor\Conditions\Listings;
use Posterno\Elementor\Documents\Listing;
use Posterno\Elementor\Documents\ListingsArchive;
use Posterno\Elementor\Helper;
use Posterno\Elementor\Skins\PosternoSkin;

/**
 * Display the custom theme builder sections for the dashboard pages.
 */
$dashboard_sections = wp_list_pluck( pno_get_dashboard_navigation_items(), 'name' );

foreach ( $dashboard_sections as $page_key => $page_name ) {
	if ( $page_key === 'logout' ) {
		continue;
	}

	add_action(
		"pno_dashboard_tab_content_{$page_key}",
		function() use ( $page_key ) {
			if ( elementor_theme_do_location( "dashboard-before-{$page_key}" ) ) {
				elementor_theme_do_location( "dashboard-before-{$page_key}" );
			}
		},
		9
	);

	add_action(
		"pno_dashboard_tab_content_{$page_key}",
		function() use ( $page_key ) {
			if ( elementor_theme_do_location( "dashboard-after-{$page_key}" ) ) {
				elementor_theme_do_location( "dashboard-after-{$page_key}" );
			}
		},
		11
	);

}

/**
 * Automatically purge cache of cards templates list when creating a new card.
 */
add_action(
	'save_post',
	function( $post_id, $post, $update ) {

		if ( $update ) {
			return;
		}

		if ( 'elementor_library' !== $post->post_type ) {
			return;
		}

		Cache::purge_cards_cache();

	},
	10,
	3
);

/**
 * Determine whether or not default cards layout should not output when
 * a custom card layout has been added through Elementor Pro.
 */
add_filter(
	'pno_bypass_card_layout',
	function( $bypass, $layout ) {

		$listing_id = get_the_id();

		$active_layout = pno_get_listings_results_active_layout();

		if ( $layout === 'list' && Helper::get_card_custom_layout( $listing_id, $active_layout ) || $layout === 'grid' && Helper::get_card_custom_layout( $listing_id, $active_layout ) ) {
			return true;
		}

		return $bypass;

	},
	10,
	2
);

/**
 * Output custom card layout when assigned through Elementor Pro.
 */
add_action(
	'pno_before_listing_in_loop',
	function() {

		$active_layout = pno_get_listings_results_active_layout();
		$listing_id    = get_the_id();

		if ( $active_layout === 'list' && Helper::get_card_custom_layout( $listing_id, $active_layout ) || $active_layout === 'grid' && Helper::get_card_custom_layout( $listing_id, $active_layout ) ) {
			echo do_shortcode( '[elementor-template id="' . absint( Helper::get_card_custom_layout( $listing_id, $active_layout ) ) . '"]' );
		}

	}
);

/**
 * Register documents for elementor pro.
 */
add_action(
	'elementor/documents/register',
	function( $manager ) {

		$manager->register_document_type( 'listings-archive', ListingsArchive::get_class_full_name() );
		$manager->register_document_type( 'listings', Listing::get_class_full_name() );

	}
);

add_action(
	'elementor/theme/register_conditions',
	function( $manager ) {

		$listings = new Listings();

		$manager->get_condition( 'general' )->register_sub_condition( $listings );

	}
);

add_action( 'elementor/widget/archive-posts/skins_init', function( $widget ) {
	$widget->add_skin( new PosternoSkin( $widget ) );
} );
