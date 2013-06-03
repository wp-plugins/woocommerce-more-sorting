<?php
/*
Plugin Name: WooCommerce More Sorting
Plugin URI: http://www.algoritmika.com/shop/wordpress-woocommerce-more-sorting-plugin/
Description: Add more sorting options to WooCommerce WordPress Plugin.
Version: 1.0.6
Author: Algoritmika Ltd.
Author URI: http://www.algoritmika.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
?>
<?php
if ( ! class_exists( 'woomoresort_plugin' ) ) {
	class woomoresort_plugin{
		public function __construct(){
		
			add_filter('woocommerce_get_catalog_ordering_args', array($this, 'custom_woocommerce_get_catalog_ordering_args'), 99); 
			add_filter('woocommerce_catalog_orderby', array($this, 'custom_woocommerce_catalog_orderby'), 99); 
			add_filter('woocommerce_default_catalog_orderby_options', array($this, 'custom_woocommerce_catalog_orderby'), 99);
		
			//Settings
			if(is_admin()){
				add_action('admin_menu', array($this, 'add_plugin_options_page'));
			}
		}
		
		function custom_woocommerce_catalog_orderby( $sortby ) {
			$sortby['title_asc'] = 'Sort: A to Z';
			$sortby['title_desc'] = 'Sort: Z to A';
			return $sortby;
		}
		
		function custom_woocommerce_get_catalog_ordering_args( $args ) {
			global $woocommerce;
			// Get ordering from query string unless defined
			$orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
			// Get order + orderby args from string
			$orderby_value = explode( '-', $orderby_value );
			$orderby       = esc_attr( $orderby_value[0] );
			//$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : $order;

			switch ($orderby) :
				case 'title_asc' :
					$args['orderby'] = 'title';
					$args['order'] = 'asc';
					$args['meta_key'] = '';
				break;			
				case 'title_desc' :
					$args['orderby'] = 'title';
					$args['order'] = 'desc';
					$args['meta_key'] = '';
				break;

			endswitch;
				
			return $args;			
			/*if (isset($_GET['orderby'])) {
				switch ($_GET['orderby']) :
					case 'title_asc' :
						$args['orderby'] = 'title';
						$args['order'] = 'asc';
						$args['meta_key'] = '';
					break;			
					case 'title_desc' :
						$args['orderby'] = 'title';
						$args['order'] = 'desc';
						$args['meta_key'] = '';
					break;
				endswitch;
			}
			return $args;*/
		}
		
		public function add_plugin_options_page(){
			add_submenu_page( 'woocommerce', 'WooCommerce More Sorting Settings Admin', 'More Sorting Settings', 'manage_options', 'woomoresorting-settings-admin', array($this, 'create_admin_page'));
		}

		public function create_admin_page(){
			?>
		<div class="wrap">
			<h2>WooCommerce More Sorting Options</h2>			
			<form method="post">
				<div id="message" class="updated fade"><p><strong>*You need <a href='http://www.algoritmika.com/shop/wordpress-woocommerce-more-sorting-pro-plugin/'>'WooCommerce More Sorting Pro'</a> plugin version to change these settings.</strong></p></div>
				<h3>Change Text</h3>
				<table class="form-table">
				<tr valign="top"><th scope="row">Text for "Sort: A to Z"</th><td><input type="text" readonly style="width:300px;" id="woomoresort_pro_textAtoZ_id" name="woomoresort_pro_option_group[woomoresort_pro_textAtoZ]" value="Sort: A to Z" /></td></tr>
				<tr valign="top"><th scope="row">Remove A to Z</th><td><input disabled type="checkbox" id="woomoresort_pro_remove_AtoZ_id" name="woomoresort_pro_option_group[woomoresort_pro_AtoZ_sorting]" /></td></tr>				
				<tr valign="top"><th scope="row">Text for "Sort: Z to A"</th><td><input type="text" readonly style="width:300px;" id="woomoresort_pro_textZtoA_id" name="woomoresort_pro_option_group[woomoresort_pro_textZtoA]" value="Sort: Z to A" /></td></tr>
				<tr valign="top"><th scope="row">Remove Z to A</th><td><input disabled type="checkbox" id="woomoresort_pro_remove_ZtoA_id" name="woomoresort_pro_option_group[woomoresort_pro_ZtoA_sorting]" /></td></tr>				
				<tr valign="top"><th scope="row">Text for "SKU: Ascending"</th><td><input type="text" readonly style="width:300px;" id="woomoresort_pro_textskuAsc_id" name="woomoresort_pro_option_group[woomoresort_pro_textskuAsc]" value="SKU: Ascending" /></td></tr>
				<tr valign="top"><th scope="row">Remove SKU Asc</th><td><input disabled type="checkbox" checked id="woomoresort_pro_remove_skuAsc_id" name="woomoresort_pro_option_group[woomoresort_pro_skuAsc_sorting]" /></td></tr>				
				<tr valign="top"><th scope="row">Text for "SKU: Descending"</th><td><input type="text" readonly style="width:300px;" id="woomoresort_pro_textskuDesc_id" name="woomoresort_pro_option_group[woomoresort_pro_textskuDesc]" value="SKU: Descending" /></td></tr>
				<tr valign="top"><th scope="row">Remove SKU Desc</th><td><input disabled type="checkbox" checked id="woomoresort_pro_remove_skuDesc_id" name="woomoresort_pro_option_group[woomoresort_pro_skuDesc_sorting]" /></td></tr>				
				</table>
				<h3>General Options</h3>
				<table class="form-table">
				<tr valign="top"><th scope="row">Remove all sorting</th><td><input disabled type="checkbox" id="woomoresort_pro_remove_sorting_id" name="woomoresort_pro_option_group[woomoresort_pro_remove_sorting]" /></td></tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
		}
	}
}

$woomoresort_plugin = &new woomoresort_plugin();