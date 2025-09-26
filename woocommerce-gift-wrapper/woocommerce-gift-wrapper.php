<?php
/**
 * Plugin Name: Gift Wrapper
 * Plugin URI: https://www.giftwrapper.app/
 * Description: Offer gift wrap options on WooCommerce cart and/or checkout pages. Let customers wrap their orders!
 * Version: 6.32
 * WC requires at least: 5.6
 * WC tested up to: 10.1.0
 * Author: WebFactory Ltd
 * Author URI: https://www.webfactoryltd.com/
 * Text Domain: woocommerce-gift-wrapper
 * Requires Plugins:  woocommerce
 *
 * Copyright: (c) 2024-2025 WebFactory Ltd  (email: support@webfactoryltd.com)
 * Copyright: (c) 2014-2024 Little Package
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('ABSPATH') || exit;
if (!defined('GIFTWRAPPER_VERSION')) {
    define('GIFTWRAPPER_VERSION', '6.32');
}
if (!defined('GIFTWRAPPER_FILE')) {
    define('GIFTWRAPPER_FILE', __FILE__);
}

if (!defined('GIFTWRAPPER_PATH')) {
    define('GIFTWRAPPER_PATH', plugin_dir_path(__FILE__));
}

if (!defined('GIFTWRAPPER_URL')) {
    define('GIFTWRAPPER_URL', plugin_dir_url(__FILE__));
}

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

add_action('before_woocommerce_init', function () {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

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
