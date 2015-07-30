<?php
/**
 * WooCommerce More Sorting - General Section Settings
 *
 * @version 2.0.0
 * @since   2.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WC_More_Sorting_Settings_General' ) ) :

class WC_More_Sorting_Settings_General {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id   = 'general';
		$this->desc = __( 'General', 'woocommerce-more-sorting' );

		$this->additional_desc_tip = __( 'You will need <a href="http://coder.fm/items/woocommerce-more-sorting-plugin/">WooCommerce More Sorting Pro</a> plugin to change value.', 'woocommerce-more-sorting' );

		add_filter( 'woocommerce_get_sections_more_sorting',              array( $this, 'settings_section' ) );
		add_filter( 'woocommerce_get_settings_more_sorting_' . $this->id, array( $this, 'get_settings' ), PHP_INT_MAX );

		// Add 'Remove All Sorting' checkbox to WooCommerce > Settings > Products
		if ( 'yes' === get_option( 'woocommerce_more_sorting_enabled' ) ) {
			add_filter( 'woocommerce_product_settings', array( $this, 'add_remove_sorting_checkbox' ), 100 );
		}
	}

	/*
	 * Add Remove All Sorting checkbox to WooCommerce > Settings > Products.
	 */
	function add_remove_sorting_checkbox( $settings ) {
		$updated_settings = array();
		foreach ( $settings as $section ) {
			if ( isset( $section['id'] ) && 'woocommerce_cart_redirect_after_add' == $section['id'] ) {
				$updated_settings[] = array(
					'title'    => __( 'More Sorting: Remove All Sorting', 'woocommerce-more-sorting' ),
					'desc'     => __( 'Completely remove sorting from the shop front end', 'woocommerce-more-sorting' ),
					'id'       => 'woocommerce_more_sorting_remove_all_enabled',
					'type'     => 'checkbox',
					'default'  => 'no',
					'custom_attributes' => array( 'readonly' => 'readonly' ),
					'desc_tip' => $this->additional_desc_tip,
				);
			}
			$updated_settings[] = $section;
		}
		return $updated_settings;
	}

	/**
	 * settings_section.
	 */
	function settings_section( $sections ) {
		$sections[ $this->id ] = $this->desc;
		return $sections;
	}

	/**
	 * get_settings.
	 */
	function get_settings() {

		$settings = array(

			array(
				'title'     => __( 'More Sorting Options', 'woocommerce-more-sorting' ),
				'type'      => 'title',
				'id'        => 'woocommerce_more_sorting_options',
			),

			array(
				'title'     => __( 'WooCommerce More Sorting', 'woocommerce-more-sorting' ),
				'desc'      => '<strong>' . __( 'Enable', 'woocommerce-more-sorting' ) . '</strong>',
				'desc_tip'  => __( 'Add more WooCommerce sorting options or remove all sorting including default.', 'woocommerce-more-sorting' ),
				'id'        => 'woocommerce_more_sorting_enabled',
				'default'   => 'yes',
				'type'      => 'checkbox',
			),

			array(
				'title'     => __( 'Sort by Name', 'woocommerce-more-sorting' ),
				'desc'      => __( 'Default: ', 'woocommerce-more-sorting' ) . __( 'Sort by title: A to Z', 'woocommerce-more-sorting' ),
				'desc_tip'  => __( 'Text to show on frontend. Leave blank to disable.', 'woocommerce-more-sorting' ),
				'id'        => 'woocommerce_more_sorting_by_name_asc_text',
				'default'   => __( 'Sort by title: A to Z', 'woocommerce-more-sorting' ),
				'type'      => 'text',
				'css'       => 'min-width:300px;',
			),

			array(
				'title'     => '',//__( 'Sort by Name - Desc', 'woocommerce-more-sorting' ),
				'desc'      => __( 'Default: ', 'woocommerce-more-sorting' ) . __( 'Sort by title: Z to A', 'woocommerce-more-sorting' ),
				'desc_tip'  => __( 'Text to show on frontend. Leave blank to disable.', 'woocommerce-more-sorting' ),
				'id'        => 'woocommerce_more_sorting_by_name_desc_text',
				'default'   => __( 'Sort by title: Z to A', 'woocommerce-more-sorting' ),
				'type'      => 'text',
				'css'       => 'min-width:300px;',
			),

			array(
				'title'     => __( 'Sort by SKU', 'woocommerce-more-sorting' ),
				'desc'      => __( 'Default: ', 'woocommerce-more-sorting' ) . __( 'Sort by SKU: low to high', 'woocommerce-more-sorting' ),
				'desc_tip'  => __( 'Text to show on frontend. Leave blank to disable.', 'woocommerce-more-sorting' ),
				'id'        => 'woocommerce_more_sorting_by_sku_asc_text',
				'default'   => __( 'Sort by SKU: low to high', 'woocommerce-more-sorting' ),
				'type'      => 'text',
				'css'       => 'min-width:300px;',
			),

			array(
				'title'     => '',//__( 'Sort by SKU - Desc', 'woocommerce-more-sorting' ),
				'desc'      => __( 'Default: ', 'woocommerce-more-sorting' ) . __( 'Sort by SKU: high to low', 'woocommerce-more-sorting' ),
				'desc_tip'  => __( 'Text to show on frontend. Leave blank to disable.', 'woocommerce-more-sorting' ),
				'id'        => 'woocommerce_more_sorting_by_sku_desc_text',
				'default'   => __( 'Sort by SKU: high to low', 'woocommerce-more-sorting' ),
				'type'      => 'text',
				'css'       => 'min-width:300px;',
			),

			array(
				'title'     => '',
				'desc'      => __( 'Sort SKUs as numbers instead of as texts', 'woocommerce-more-sorting' ),
				'id'        => 'woocommerce_more_sorting_by_sku_num_enabled',
				'default'   => 'no',
				'type'      => 'checkbox',
				'custom_attributes' => array( 'disabled' => 'disabled' ),
				'desc_tip'  => $this->additional_desc_tip,

			),

			array(
				'title'     => __( 'Sort by stock quantity', 'woocommerce-more-sorting' ),
				'desc'      => __( 'Default: ', 'woocommerce-more-sorting' ) . __( 'Sort by stock quantity: low to high', 'woocommerce-more-sorting' ),
				'desc_tip'  => __( 'Text to show on frontend. Leave blank to disable.', 'woocommerce-more-sorting' ),
				'id'        => 'woocommerce_more_sorting_by_stock_quantity_asc_text',
				'default'   => __( 'Sort by stock quantity: low to high', 'woocommerce-more-sorting' ),
				'type'      => 'text',
				'css'       => 'min-width:300px;',
			),

			array(
				'title'     => '',//__( 'Sort stock quantity - Desc', 'woocommerce-more-sorting' ),
				'desc'      => __( 'Default: ', 'woocommerce-more-sorting' ) . __( 'Sort by stock quantity: high to low', 'woocommerce-more-sorting' ),
				'desc_tip'  => __( 'Text to show on frontend. Leave blank to disable.', 'woocommerce-more-sorting' ),
				'id'        => 'woocommerce_more_sorting_by_stock_quantity_desc_text',
				'default'   => __( 'Sort by stock quantity: high to low', 'woocommerce-more-sorting' ),
				'type'      => 'text',
				'css'       => 'min-width:300px;',
			),

			array(
				'type'      => 'sectionend',
				'id'        => 'woocommerce_more_sorting_options',
			),

			array(
				'title'     => __( 'Remove Sorting', 'woocommerce-more-sorting' ),
				'type'      => 'title',
				'id'        => 'woocommerce_more_sorting_remove_options',
			),

			array(
				'title'     => __( 'Remove All Sorting (including WooCommerce default)', 'woocommerce-more-sorting' ),
				'desc'      => __( 'Remove', 'woocommerce-more-sorting' ),
				'id'        => 'woocommerce_more_sorting_remove_all_enabled',
				'default'   => 'no',
				'type'      => 'checkbox',
				'custom_attributes' => array( 'disabled' => 'disabled' ),
				'desc_tip'  => $this->additional_desc_tip,
			),

			array(
				'type'      => 'sectionend',
				'id'        => 'woocommerce_more_sorting_remove_options',
			),

		);

		return $settings;
	}

}

endif;

return new WC_More_Sorting_Settings_General();
