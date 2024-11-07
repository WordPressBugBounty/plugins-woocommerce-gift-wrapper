<?php

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'GIFTWRAPPER_PLUGIN_FILE' ) ) {
	define( 'GIFTWRAPPER_PLUGIN_FILE', __FILE__ );
}

/**
 * Functions used by plugins
 */
if ( ! class_exists( 'WC_Dependencies' ) ) {
	require_once 'woo-includes/class-wc-dependencies.php';
}

/**
 * WooCommerce Detection
 *
 * @return boolean
 */
if ( ! function_exists( 'is_woocommerce_active' ) ) {
	function is_woocommerce_active() {
		return WC_Dependencies::woocommerce_active_check();
	}
}

/**
 * Ensure that WooCommerce plugin is active
 *
 * @return void
 */
if ( ! is_woocommerce_active() ) {
	add_action( 'admin_notices', 'wcgw_woocommerce_inactive_notice' );
	return;
}

/**
 * Include the main Gift Wrapper class
 *
 * @return void
 */
if ( ! class_exists( 'The_Gift_Wrapper', false ) ) {
	try {
		include_once 'includes/class-gift-wrapper.php';
	} catch ( Exception $e ) {
		deactivate_plugins( 'woocommerce-gift-wrapper/woocommerce-gift-wrapper.php' );
	}
}

/**
 * Return the main instance of Gift Wrapper for WooCommerce
 *
 * @since  5.2.3
 * @return object|The_Gift_Wrapper
 *
 */
function WC_Gift_Wrap() {
	if ( class_exists( 'The_Gift_Wrapper', false ) ) {
		return The_Gift_Wrapper::instance();
	}
}

WC_Gift_Wrap();

/**
 * Stating the obvious. Can't have Gift Wrapper without WooCommerce
 *
 * @return void
 */
function wcgw_woocommerce_inactive_notice() { ?>

	<div id="message" class="notice notice-error is-dismissible">
		<p><?php esc_html_e( 'The WooCommerce plugin must be active in order to activate and use WooCommerce Gift Wrapper.', 'woocommerce-gift-wrapper' ); ?></p>
	</div>

	<?php
	deactivate_plugins( 'woocommerce-gift-wrapper/woocommerce-gift-wrapper.php' );

}