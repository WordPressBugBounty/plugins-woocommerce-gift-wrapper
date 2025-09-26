<?php defined( 'ABSPATH' ) || exit;

	class The_Gift_Wrapper_Settings_Product {

		/**
		 * Constructor
		 */
		public function __construct() {

			if ( ! is_admin() ) {
				return;
			}

			// Add settings to WooCommerce simple product
			add_filter( 'woocommerce_product_data_tabs',    [ $this, 'product_write_panel_tab' ] );

			// Add the panel and items to the product interface
			add_action( 'woocommerce_product_data_panels',  [ $this, 'product_data_panel' ] );

		}

		/**
		 * Adds a new tab to the product interface
		 *
		 * @param  array $tabs
		 * @return array
		 */
		public function product_write_panel_tab( $tabs ) {

			if ( isset( $tabs['gift-wrapper'] ) ) {
				return $tabs;
			}

			global $post;
			if ( ! is_object( $post ) ) {
				return $tabs;
			}
			?>

			<style>#woocommerce-product-data ul.wc-tabs li.gift-wrapper-tab a::before{content:"\f328"}</style>

			<?php
			$tabs['gift-wrapper'] = array(
				'label'  => __( 'Gift Wrapper', 'woocommerce-gift-wrapper' ),
				'target' => 'gift-wrapper-product-options',
				'class'  => [ 'gift-wrapper-tab' ],
			);
			return $tabs;

		}

		/**
		 * Adds the panel and items to the product interface
		 *
		 * @return void
		 */
		public function product_data_panel() {
			?>
				<div id="gift-wrapper-product-options" class="panel woocommerce_options_panel hidden">
					<div class="options_group" style="padding:2em">
							<strong>Per-product gift wrap settings are a feature of <a href="<?php echo admin_url('admin.php?page=wc-settings&tab=gift-wrapper'); ?>#open-pro-dialog">Gift Wrapper PRO</a>.</strong>
                            <br /><br />
							<a href="<?php echo admin_url('admin.php?page=wc-settings&tab=gift-wrapper'); ?>" rel="noopener" class="button">Open WooCommerce Global Gift Wrap Settings</a>
					</div>
				</div>
			<?php
		}

	}
