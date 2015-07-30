<?php
/*
Plugin Name: WooCommerce More Sorting
Plugin URI: http://coder.fm/items/woocommerce-more-sorting-plugin
Description: Add more WooCommerce sorting options.
Version: 2.0.0
Author: Algoritmika Ltd
Author URI: http://www.algoritmika.com
Copyright: © 2015 Algoritmika Ltd.
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Check if WooCommerce is active
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;

if ( ! class_exists( 'Woocommerce_More_Sorting' ) ) :

/**
 * Main Woocommerce_More_Sorting Class
 *
 * @class Woocommerce_More_Sorting
 */

final class Woocommerce_More_Sorting {

	/**
	 * @var Woocommerce_More_Sorting The single instance of the class
	 */
	protected static $_instance = null;

	/**
	 * Main Woocommerce_More_Sorting Instance
	 *
	 * Ensures only one instance of Woocommerce_More_Sorting is loaded or can be loaded.
	 *
	 * @static
	 * @return Woocommerce_More_Sorting - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	}

	/**
	 * Woocommerce_More_Sorting Constructor.
	 * @access public
	 */
	public function __construct() {

		// Include required files
		$this->includes();

		add_action( 'init', array( $this, 'init' ), 0 );

		// Settings
		if ( is_admin() ) {
			add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ), 9 );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
		}
	}

	/**
	 * Show action links on the plugin screen
	 *
	 * @param mixed $links
	 * @return array
	 */
	public function action_links( $links ) {
		return array_merge( array(
			'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=more_sorting' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>',
		), $links );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	private function includes() {

		$settings = array();
		$settings[] = require_once( 'includes/admin/class-wc-more-sorting-settings-general.php' );
		if ( is_admin() ) {
			foreach ( $settings as $section ) {
				foreach ( $section->get_settings() as $value ) {
					if ( isset( $value['default'] ) && isset( $value['id'] ) ) {
						if ( isset ( $_GET['woocommerce_more_sorting_admin_options_reset'] ) ) {
							require_once( ABSPATH . 'wp-includes/pluggable.php' );
							if ( is_super_admin() ) {
								delete_option( $value['id'] );
							}
						}
						$autoload = isset( $value['autoload'] ) ? ( bool ) $value['autoload'] : true;
						add_option( $value['id'], $value['default'], '', ( $autoload ? 'yes' : 'no' ) );
					}
				}
			}
		}

		require_once( 'includes/class-wc-more-sorting.php' );
	}

	/**
	 * Add Woocommerce settings tab to WooCommerce settings.
	 */
	public function add_woocommerce_settings_tab( $settings ) {
		$settings[] = include( 'includes/admin/class-wc-settings-more-sorting.php' );
		return $settings;
	}

	/**
	 * Init Woocommerce_More_Sorting when WordPress initialises.
	 */
	public function init() {
		// Set up localisation
		load_plugin_textdomain( 'woocommerce-more-sorting', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
}

endif;

/**
 * Returns the main instance of Woocommerce_More_Sorting to prevent the need to use globals.
 *
 * @return Woocommerce_More_Sorting
 */
function WCMS() {
	return Woocommerce_More_Sorting::instance();
}

WCMS();
