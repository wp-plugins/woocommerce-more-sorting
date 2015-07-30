<?php
/**
 * WooCommerce More Sorting - Settings
 *
 * @version 2.0.0
 * @since   2.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WC_Settings_More_Sorting' ) ) :

class WC_Settings_More_Sorting extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	function __construct() {

		$this->id    = 'more_sorting';
		$this->label = __( 'More Sorting', 'woocommerce-more-sorting' );

		parent::__construct();
	}

	public function get_settings() {
		global $current_section;
		$the_current_section = ( '' != $current_section ) ? $current_section : 'general';
		return apply_filters( 'woocommerce_get_settings_' . $this->id . '_' . $the_current_section, array() );
	}

	/**
	 * Output sections.
	 */
	public function output_sections() {

	}
}

endif;

return new WC_Settings_More_Sorting();
