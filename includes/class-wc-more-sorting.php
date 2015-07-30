<?php
/**
 * WooCommerce More Sorting
 *
 * @version 2.0.0
 * @since   2.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WC_More_Sorting' ) ) :

class WC_More_Sorting {

	/**
	 * Constructor.
	 */
	public function __construct() {

		if ( 'yes' === get_option( 'woocommerce_more_sorting_enabled' ) ) {
			add_filter( 'woocommerce_get_catalog_ordering_args',       array( $this, 'custom_woocommerce_get_catalog_ordering_args' ), PHP_INT_MAX );
			add_filter( 'woocommerce_catalog_orderby',                 array( $this, 'custom_woocommerce_catalog_orderby' ),           PHP_INT_MAX ); // front end
			add_filter( 'woocommerce_default_catalog_orderby_options', array( $this, 'custom_woocommerce_catalog_orderby' ),           PHP_INT_MAX );
		}
	}

	/*
	 * maybe_add_sorting.
	 */
	private function maybe_add_sorting( $sortby, $option_name, $key ) {
		if ( '' != get_option( $option_name ) ) {
			$sortby[ $key ] = get_option( $option_name );
		}
		return $sortby;
	}

	/*
	 * Add new sorting options to Front End and to Back End (in WooCommerce > Settings > Products > Default Product Sorting).
	 */
	function custom_woocommerce_catalog_orderby( $sortby ) {

		$sortby = $this->maybe_add_sorting( $sortby, 'woocommerce_more_sorting_by_name_asc_text',            'title_asc' );
		$sortby = $this->maybe_add_sorting( $sortby, 'woocommerce_more_sorting_by_name_desc_text',           'title_desc' );
		$sortby = $this->maybe_add_sorting( $sortby, 'woocommerce_more_sorting_by_sku_asc_text',             'sku_asc' );
		$sortby = $this->maybe_add_sorting( $sortby, 'woocommerce_more_sorting_by_sku_desc_text',            'sku_desc' );
		$sortby = $this->maybe_add_sorting( $sortby, 'woocommerce_more_sorting_by_stock_quantity_asc_text',  'stock_quantity_asc' );
		$sortby = $this->maybe_add_sorting( $sortby, 'woocommerce_more_sorting_by_stock_quantity_desc_text', 'stock_quantity_desc' );

		return $sortby;
	}

	/*
	 * Add new sorting options to WooCommerce sorting.
	 */
	function custom_woocommerce_get_catalog_ordering_args( $args ) {

		global $woocommerce;
		// Get ordering from query string unless defined
		$orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		// Get order + orderby args from string
		$orderby_value = explode( '-', $orderby_value );
		$orderby       = esc_attr( $orderby_value[0] );

		switch ( $orderby ) :
			case 'title_asc':
				$args['orderby'] = 'title';
				$args['order'] = 'asc';
				$args['meta_key'] = '';
			break;
			case 'title_desc':
				$args['orderby'] = 'title';
				$args['order'] = 'desc';
				$args['meta_key'] = '';
			break;
			case 'sku_asc':
				$args['orderby'] = 'meta_value';
				$args['order'] = 'asc';
				$args['meta_key'] = '_sku';
			break;
			case 'sku_desc':
				$args['orderby'] = 'meta_value';
				$args['order'] = 'desc';
				$args['meta_key'] = '_sku';
			break;
			case 'stock_quantity_asc':
				$args['orderby'] = 'meta_value_num';
				$args['order'] = 'asc';
				$args['meta_key'] = '_stock';
			break;
			case 'stock_quantity_desc':
				$args['orderby'] = 'meta_value_num';
				$args['order'] = 'desc';
				$args['meta_key'] = '_stock';
			break;
		endswitch;

		return $args;
	}
}

endif;

return new WC_More_Sorting();
