<?php
/*
Plugin Name: WooCommerce More Sorting
Plugin URI: http://www.algoritmika.com/shop/wordpress-woocommerce-more-sorting-plugin/
Description: Add more sorting options to WooCommerce WordPress Plugin.
Version: 1.0.0
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
			if (isset($_GET['orderby'])) {
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
			return $args;
		}
		
		public function add_plugin_options_page(){
			add_submenu_page( 'woocommerce', 'WooCommerce More Sorting Settings Admin', 'More Sorting Settings', 'manage_options', 'woomoresorting-settings-admin', array($this, 'create_admin_page'));
		}

		public function create_admin_page(){
			?>
		<div class="wrap">
			<h2>WooCommerce More Sorting Options</h2>			
			<form method="post" action="options.php">
				<div id="message" class="updated fade"><p><strong>*You need <a href='http://www.algoritmika.com/shop/wordpress-woocommerce-more-sorting-pro-plugin/'>'WooCommerce More Sorting Pro'</a> plugin version to change these settings.</strong></p></div>
				<h3>Change Text</h3>
				<table class="form-table">
				<tr valign="top"><th scope="row">Text for "Sort: A to Z"</th><td><input type="text" readonly style="width:300px;" id="woomoresort_pro_textAtoZ_id" name="woomoresort_pro_option_group[woomoresort_pro_textAtoZ]" value="Sort: A to Z" /></td></tr>
				<tr valign="top"><th scope="row">Text for "Sort: Z to A"</th><td><input type="text" readonly style="width:300px;" id="woomoresort_pro_textZtoA_id" name="woomoresort_pro_option_group[woomoresort_pro_textZtoA]" value="Sort: Z to A" /></td></tr>
				</table>
				<h3>General Options</h3>
				<table class="form-table">
				<tr valign="top"><th scope="row">Display on single product</th><td><input disabled type="checkbox" checked id="woomoresort_pro_remove_sorting_id" name="woomoresort_pro_option_group[woomoresort_pro_remove_sorting]" /></td></tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
		}
	}
}

$woomoresort_plugin = &new woomoresort_plugin();