<?php

/**
 * Plugin Name: Gift Wrapper
 * Plugin URI: https://www.giftwrapper.app
 * Description: Offer gift wrap options on WooCommerce cart and/or checkout pages. Let customers wrap their orders!
 * Version: 6.2.5
 * WC requires at least: 5.6
 * WC tested up to: 9.3
 * Author: Gift Wrapper
 * Author URI: https://www.giftwrapper.app
 * Text Domain: woocommerce-gift-wrapper
 * Domain Path: /lang
 * Requires Plugins:  woocommerce
 *
 * Gift Wrapper - for WooCommerce - since 2014
 * Copyright: (c) 2014-2024 Little Package
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * This plugin is free. If you have problems with it, please be
 * nice and contact me for help before leaving negative feedback.
 * Together we can make WordPress better. Thank you.
 *
 * Maybe you can leave a positive review?
 *
 * https://wordpress.org/support/plugin/woocommerce-gift-wrapper/reviews
 *
 * Thank you!
 *
 */
use GiftWrapper\WoocommerceGiftWrapper;
defined( 'ABSPATH' ) || exit;
if ( !defined( 'GIFTWRAPPER_VERSION' ) ) {
    define( 'GIFTWRAPPER_VERSION', '6.2.5' );
}
if ( !defined( 'GIFTWRAPPER_FILE' ) ) {
    define( 'GIFTWRAPPER_FILE', __FILE__ );
}
if ( !defined( 'GIFTWRAPPER_PATH' ) ) {
    define( 'GIFTWRAPPER_PATH', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'GIFTWRAPPER_URL' ) ) {
    define( 'GIFTWRAPPER_URL', plugin_dir_url( __FILE__ ) );
}
if ( function_exists( 'wcgw_fs' ) ) {
    wcgw_fs()->set_basename( false, __FILE__ );
} else {
    // Create a helper function for easy SDK access.
    function wcgw_fs() {
        global $wcgw_fs;
        if ( !isset( $wcgw_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/vendor/freemius/wordpress-sdk/start.php';
            $wcgw_fs = fs_dynamic_init( array(
                'id'             => '16940',
                'slug'           => 'woocommerce-gift-wrapper',
                'premium_slug'   => 'woocommerce-gift-wrapper-plus',
                'type'           => 'plugin',
                'public_key'     => 'pk_c73db55aecacb0b8300d6a154b066',
                'is_premium'     => false,
                'premium_suffix' => 'plus',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                    'slug'           => 'wc-settings',
                    'override_exact' => true,
                    'first-path'     => 'admin.php?page=wc-settings&tab=gift-wrapper',
                    'support'        => false,
                    'parent'         => array(
                        'slug' => 'wc-settings',
                    ),
                ),
                'is_live'        => true,
            ) );
        }
        return $wcgw_fs;
    }

    // Init Freemius.
    wcgw_fs();
    // Signal that SDK was initiated.
    do_action( 'wcgw_fs_loaded' );
    require_once __DIR__ . '/vendor/autoload.php';
    /**
     * Declare compatibility with HPOS
     * @return void
     */
    add_action( 'before_woocommerce_init', function () {
        if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
        }
    } );
    function wcgw_fs_settings_url() {
        return admin_url( 'admin.php?page=wc-settings&tab=gift-wrapper' );
    }

    wcgw_fs()->add_filter( 'connect_url', 'wcgw_fs_settings_url' );
    wcgw_fs()->add_filter( 'after_skip_url', 'wcgw_fs_settings_url' );
    wcgw_fs()->add_filter( 'after_connect_url', 'wcgw_fs_settings_url' );
    wcgw_fs()->add_filter( 'after_pending_connect_url', 'wcgw_fs_settings_url' );
    require_once 'free/woocommerce-gift-wrapper.php';
    new WoocommerceGiftWrapper();
}