<?php

defined('ABSPATH') || exit; // Exit if accessed directly

final class The_Gift_Wrapper
{

    /**
     * Single instance of the The_Gift_Wrapper class
     *
     * @var The_Gift_Wrapper
     */
    protected static $_instance = null;

    /**
     * Wrapping instance.
     *
     * @var The_Gift_Wrapper_Wrapping
     */
    public $wrapping = null;

    /**
     * Settings instance.
     *
     * @var The_Gift_Wrapper_Settings
     */
    public $settings = null;

    /**
     * Strings instance.
     *
     * @var WCGWP_Strings
     */
    public $strings = [];

    /**
     * Main Gift Wrapper Instance
     *
     * Ensures only one instance of Gift Wrapper is loaded or can be loaded
     *
     * @since 1.0
     * @static
     * @see WC_Gift_Wrap()
     * @return The_Gift_Wrapper - Main instance
     */
    public static function instance()
    {

        if (! isset(self::$_instance) && ! (self::$_instance instanceof The_Gift_Wrapper)) {
            self::$_instance = new The_Gift_Wrapper;
        }
        return self::$_instance;
    }

    /**
     * Cloning instances of the class is forbidden
     */
    public function __clone()
    {

        _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; uh?', 'woocommerce-gift-wrapper'), esc_attr(GIFTWRAPPER_VERSION));
    }

    /**
     * Unserializing instances of this class is forbidden
     */
    public function __wakeup()
    {

        _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; uh?', 'woocommerce-gift-wrapper'), esc_attr(GIFTWRAPPER_VERSION));
    }

    /**
     * Constructor
     */
    public function __construct()
    {

        register_activation_hook(GIFTWRAPPER_PLUGIN_FILE, [$this, 'activation_hook']);

        $this->define_constants();
        $this->includes();

        add_action('plugins_loaded',           [$this, 'plugins_loaded']);

        add_action('init',                     [$this, 'init']);

        add_action('admin_init',               [$this, 'admin_init']);

        add_action('admin_enqueue_scripts',    [$this, 'admin_enqueue_scripts'], 10, 1);

        add_action('wp_enqueue_scripts',       [$this, 'wp_enqueue_scripts'], 11);

        $this->settings = new The_Gift_Wrapper_Settings();

        if (is_admin()) {
            new The_Gift_Wrapper_Admin_Notices();
            new The_Gift_Wrapper_Settings_Product();
        }

        $this->wrapping = new The_Gift_Wrapper_Wrapping();
    }

    /**
     * Deactivate the free version of WaterWoo if active
     *
     * @return void
     */
    public function activation_hook()
    {

        if (! function_exists('is_plugin_active')) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        if (is_plugin_active('woocommerce-gift-wrapper-plus/woocommerce-gift-wrapper-plus.php')) {
            deactivate_plugins('woocommerce-gift-wrapper-plus/woocommerce-gift-wrapper-plus.php');
        }
    }

    /**
     * Define constants used by plugin
     *
     * @return void
     */
    private function define_constants()
    {

        if (! defined('GIFTWRAPPER_PLUGIN_DIR')) {
            define('GIFTWRAPPER_PLUGIN_DIR', plugin_dir_path(GIFTWRAPPER_PLUGIN_FILE));
        }
        if (! defined('GIFTWRAPPER_PLUGIN_BASE_FILE')) {
            define('GIFTWRAPPER_PLUGIN_BASE_FILE', plugin_basename(GIFTWRAPPER_PLUGIN_FILE));
        }
    }

    /**
     * Include required files
     *
     * @return void
     */
    public function includes()
    {

        include_once GIFTWRAPPER_PLUGIN_DIR . 'includes/functions.php';
        include_once GIFTWRAPPER_PLUGIN_DIR . 'includes/class-gift-wrapper-feedback.php';
        include_once GIFTWRAPPER_PLUGIN_DIR . 'includes/class-gift-wrapper-admin-notices.php';
        include_once GIFTWRAPPER_PLUGIN_DIR . 'includes/class-gift-wrapper-settings.php';
        include_once GIFTWRAPPER_PLUGIN_DIR . 'includes/class-gift-wrapper-settings-product.php';
        include_once GIFTWRAPPER_PLUGIN_DIR . 'includes/class-gift-wrapper-wrapping.php';
        include_once GIFTWRAPPER_PLUGIN_DIR . 'includes/class-wcgwp-strings.php';
    }

    /**
     * Load the localization
     *
     * @return void
     */
    public function plugins_loaded()
    {

        if (function_exists('determine_locale')) {
            $locale = determine_locale();
            $locale = apply_filters('plugin_locale', $locale, 'woocommerce-gift-wrapper');
            unload_textdomain('woocommerce-gift-wrapper');
            load_textdomain('woocommerce-gift-wrapper', WP_LANG_DIR . '/woocommerce-gift-wrapper/woocommerce-gift-wrapper-' . $locale . '.mo');
            load_plugin_textdomain('woocommerce-gift-wrapper', false, dirname(plugin_basename(GIFTWRAPPER_PLUGIN_FILE)) . '/lang'); //phpcs:ignore
        } else {
            load_plugin_textdomain('woocommerce-gift-wrapper', false, dirname(plugin_basename(GIFTWRAPPER_PLUGIN_FILE)) . '/lang'); //phpcs:ignore
        }
    }

    /**
     * Init hook
     *
     * @return void
     */
    public function init()
    {

        if (is_plugin_active('woocommerce-gift-wrapper-plus/woocommerce-gift-wrapper-plus.php')) {
            deactivate_plugins('woocommerce-gift-wrapper-plus/woocommerce-gift-wrapper-plus.php');
        }

        $this->strings = new WCGWP_Strings();

        if ($this->is_elementor_pro_active()) {
            add_action('elementor/frontend/after_register_styles',     [$this, 'elementor_frontend_styles']);
            add_action('elementor/frontend/after_register_scripts',    [$this, 'elementor_frontend_scripts']);
            add_action('elementor/widgets/register',                   [$this, 'register_elementor_widget']);
        }
    }

    /**
     * @return void
     */
    public function elementor_frontend_styles()
    {

        $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

        // General CSS
        wp_register_style('wcgwp-css', plugins_url('/assets/v6/css/wcgwp' . $suffix . '.css', GIFTWRAPPER_PLUGIN_FILE), [], GIFTWRAPPER_VERSION, 'screen');
        // Modal CSS
        wp_register_style('wcgwp-modal-css', plugins_url('/assets/v6/css/wcgwp-modal' . $suffix . '.css', GIFTWRAPPER_PLUGIN_FILE), [], GIFTWRAPPER_VERSION, 'screen');
    }

    /**
     * @return void
     */
    public function elementor_frontend_scripts()
    {

        // Kane Cohen's vanilla modal script
        wp_register_script('wcgwp-modal', plugins_url('/assets/js/modal-vanilla/modal.min.js', GIFTWRAPPER_PLUGIN_FILE), [], GIFTWRAPPER_VERSION, true);

        // Modal and slide
        wp_register_script('wcgwp-cart', plugins_url('/assets/v6/js/wcgwp-cart.min.js', GIFTWRAPPER_PLUGIN_FILE), ['jquery', 'wcgwp-modal', 'wc-cart', 'wc-add-to-cart'], GIFTWRAPPER_VERSION, true);
    }

    /**
     * Elementor widget init
     *
     * @param object $widgets_manager
     * @return void
     */
    public function register_elementor_widget($widgets_manager)
    {

        include_once GIFTWRAPPER_PLUGIN_DIR . 'includes/class-gift-wrapper-elementor-widget.php';
        $widgets_manager->register(new Gift_Wrapper_Elementor_Widget());
    }

    /**
     * Admin init hook (only runs admin-side)
     *
     * @return void
     */
    public function admin_init()
    {

        // Database update
        $this->update_db();
    }

    /**
     * Enqueue admin-side scripts
     *
     * @param  string $hook_suffix
     * @return void
     */
    public function admin_enqueue_scripts($hook_suffix)
    {
        wp_register_script('wcgiftwrap-admin-js', plugins_url('/assets/js/gift-wrapper-admin.min.js', GIFTWRAPPER_PLUGIN_FILE), ['jquery'], GIFTWRAPPER_VERSION);
        //phpcs:ignore missing nonce for $_GET['tab'] as it can be accessed directly
        if ('woocommerce_page_wc-settings' === $hook_suffix && isset($_GET['tab']) && 'gift-wrapper' === $_GET['tab']) { //phpcs:ignore
            wp_enqueue_script('wcgiftwrap-admin-js');
        }
    }

    /**
     * Enqueue scripts
     *
     * @return void
     */
    public function wp_enqueue_scripts()
    {

        $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

        $v6 = 'no' === get_option('wcgwp_lt6_templates', 'no') ? 'v6/' : '';
        $display = get_option('wcgwp_cart_display', 'modal');


        if (! empty($v6)) {

            // Modal, Slide & Checkbox
            wp_register_style('wcgwp-css', plugins_url('/assets/v6/css/wcgwp' . $suffix . '.css', GIFTWRAPPER_PLUGIN_FILE), [], GIFTWRAPPER_VERSION);
            // Modal
            wp_register_style('wcgwp-modal-css', plugins_url('/assets/v6/css/wcgwp-modal' . $suffix . '.css', GIFTWRAPPER_PLUGIN_FILE), ['wcgwp-css'], GIFTWRAPPER_VERSION);
            wp_register_script('wcgwp-modal', plugins_url('/assets/js/modal-vanilla/modal.min.js', GIFTWRAPPER_PLUGIN_FILE), [], GIFTWRAPPER_VERSION, true);
            // Modal, Slide & Checkbox
            wp_register_script('wcgwp-cart', plugins_url('/assets/v6/js/wcgwp-cart.min.js', GIFTWRAPPER_PLUGIN_FILE), ['jquery', 'wc-cart', 'wc-add-to-cart', 'wcgwp-modal'], GIFTWRAPPER_VERSION, true);

            if (is_cart() || is_checkout() || is_single()) { // Elementor widget cart/checkout does not trigger this

                if ('modal' === $display) {
                    wp_enqueue_style('wcgwp-css');
                    wp_enqueue_style('wcgwp-modal-css');
                    wp_enqueue_script('wcgwp-modal');
                } else {
                    wp_enqueue_style('wcgwp-css');
                }
                wp_enqueue_script('wcgwp-cart');
            }
            $is_cart = is_cart() ? true : false;

            if ($this->is_elementor_pro_active()) {
                global $post;
                if ($post) {
                    $elementor_data = get_post_meta($post->ID, '_elementor_data', true);
                    if (false !== strpos($elementor_data, '"widgetType":"woocommerce-cart"')) {
                        $is_cart = true;
                    } else if (false !== strpos($elementor_data, '"widgetType":"woocommerce-checkout"')) {
                        $is_cart = false; // it's checkout
                    }
                }
            }
            wp_add_inline_script(
                'wcgwp-cart',
                sprintf(
                    'const wcgwpAjaxURL="%s",wcgwpIsCart="%s",wcgwpReplaceText="%s",wcgwpNoProductText="%s",wcgwpWidth="%s";',
                    admin_url('admin-ajax.php'),
                    $is_cart,
                    esc_js(__('Are you sure you want to replace the gift wrap in your cart?', 'woocommerce-gift-wrapper')),
                    esc_js(__('Please choose a gift wrap product to continue.', 'woocommerce-gift-wrapper')),
                    in_array('woocommerce_before_cart_collaterals', get_option('wcgwp_cart_hook', []))
                ),
                'before'
            );
            return;
        }

        // Older versions:
        wp_register_style('wcgiftwrap-modal-css', plugins_url('/assets/css/gift-wrapper-modal' . $suffix . '.css', GIFTWRAPPER_PLUGIN_FILE), [], GIFTWRAPPER_VERSION);

        wp_register_script('wcgwp-modal', plugins_url('assets/js/modal-vanilla/modal.min.js', GIFTWRAPPER_PLUGIN_FILE), [], GIFTWRAPPER_VERSION, true);
        wp_register_script('wcgwp-modal-cart-checkout', plugins_url('assets/js/gift-wrapper-modal' . $suffix . '.js', GIFTWRAPPER_PLUGIN_FILE), ['wcgwp-modal'], GIFTWRAPPER_VERSION, true);

        wp_register_style('wcgiftwrap-css', plugins_url('/assets/css/gift-wrapper-slide' . $suffix . '.css', GIFTWRAPPER_PLUGIN_FILE), [], GIFTWRAPPER_VERSION);
        wp_register_script('wcgwp-slide-cart-checkout', plugins_url('assets/js/gift-wrapper-slide' . $suffix . '.js', GIFTWRAPPER_PLUGIN_FILE), ['jquery'], GIFTWRAPPER_VERSION, true);

        if (is_cart() || is_checkout() || is_single()) {

            if ('modal' === $display) {
                wp_enqueue_style('wcgiftwrap-modal-css');
                wp_enqueue_script('wcgwp-modal');
                wp_enqueue_script('wcgwp-modal-cart-checkout');
                wp_localize_script(
                    'wcgwp-modal-cart-checkout',
                    'wcgwpModal',
                    [
                        'ajaxurl' => admin_url('admin-ajax.php'),
                        'number' => sanitize_text_field(get_option('wcgwp_number', 'no')),
                        'wrapInCart' => wcgwp_wrap_in_cart(),
                        'replaceText' => esc_js(__('Are you sure you want to replace the gift wrap in your cart?', 'woocommerce-gift-wrapper')),
                    ]
                );
            } else if ('slide' === $display) {
                wp_enqueue_style('wcgiftwrap-css');
                wp_enqueue_script('wcgwp-slide-cart-checkout');
                wp_localize_script(
                    'wcgwp-slide-cart-checkout',
                    'wcgwpSlide',
                    [
                        'ajaxurl'       => admin_url('admin-ajax.php'),
                        'number'        => sanitize_text_field(get_option('wcgwp_number', 'no')),
                        'wrapInCart'    => wcgwp_wrap_in_cart(),
                        'replaceText'   => esc_js(__('Are you sure you want to replace the gift wrap in your cart?', 'woocommerce-gift-wrapper')),
                    ]
                );
            }
        }

        if (in_array('woocommerce_before_cart_collaterals', get_option('wcgwp_cart_hook', []))) {
            wp_add_inline_script(
                'wcgwp-modal-cart-checkout',
                'var wcgwpWidth=jQuery(".cart-collaterals").css("width"),wcgwpFloat=jQuery(".cart-collaterals").css("float");if("none"!==wcgwpFloat){wcgwpWidth&&wcgwpFloat&&jQuery(".wc-giftwrap.giftwrap_coupon").attr("style","width:"+wcgwpWidth+";float:"+wcgwpFloat+";clear:none")}',
                'before'
            );
        }

        if (in_array('woocommerce_before_cart_collaterals', get_option('wcgwp_cart_hook', []))) {
            wp_add_inline_script(
                'wcgwp-slide-cart-checkout',
                'var wcgwpWidth=jQuery(".cart-collaterals").css("width"),wcgwpFloat=jQuery(".cart-collaterals").css("float");if("none"!==wcgwpFloat){wcgwpWidth&&wcgwpFloat&&jQuery(".wc-giftwrap.giftwrap_coupon").attr("style","width:"+wcgwpWidth+";float:"+wcgwpFloat+";clear:none")}',
                'before'
            );
        }
    }

    /**
     * Update Gift Wrapper database entries as plugin evolves
     *
     * @since  4.0.3
     * @return void
     */
    public function update_db()
    {

        $_version = get_option('wcGIFTWRAPPER_VERSION');
        if ($_version) {
            update_option('wcgw_version', $_version);
            delete_option('wcGIFTWRAPPER_VERSION');
        }

        if ($display = get_option('wcgwp_modal')) {
            if ('no' === $display) {
                $display = 'slide';
            } else {
                $display = 'modal';
            }
            update_option('wcgwp_cart_display', $display);
            delete_option('wcgwp_modal');
        }

        delete_option('wcgwp_donate_dismiss_06-28');

        if ($displays = get_option('wcgwp_display')) {
            $new_display = [];
            foreach ($displays as $display) {
                if ('none' === $display) {
                    $new_display[] = 'none';
                    break;
                } else if ('before_cart' === $display) {
                    $new_display[] = 'woocommerce_before_cart';
                } else if ('after_coupon' === $display) {
                    $new_display[] = 'woocommerce_before_cart_collaterals';
                } else if ('after_cart' === $display) {
                    $new_display[] = 'woocommerce_after_cart';
                } else if ('before_checkout' === $display) {
                    $new_display[] = 'woocommerce_before_checkout_form';
                } else if ('after_checkout' === $display) {
                    $new_display[] = 'woocommerce_after_checkout_form';
                }
            }
            update_option('wcgwp_cart_hook', $new_display);
            delete_option('wcgwp_display');
        }

        if ($details = get_option('wcgwp_details')) {
            delete_option('wcgwp_details');
            $strings = get_option('wcgwp_strings', []);
            if (empty($strings)) {
                $strings = WC_Gift_Wrap()->strings->get_default_strings();
            }
            $strings['wrap_details'] = $details;
            update_option('wcgwp_strings', $strings, false);
        }

        if (! get_option('wcgwp_lt6_templates')) {
            update_option('wcgwp_lt6_templates', 'no');
        }

        update_option('wcgw_version', GIFTWRAPPER_VERSION, 'no');
    }

    /**
     * Determine if the Elementor Pro plugin is active
     *
     * @return boolean
     */
    private function is_elementor_pro_active()
    {

        if (! function_exists('is_plugin_active')) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        if (is_plugin_active('elementor-pro/elementor-pro.php') && 'no' === get_option('wcgwp_lt6_templates', 'no')) {
            return true;
        }
        return false;
    }

    static function wp_kses_wf($html, $return = false)
    {
        add_filter('safe_style_css', function ($styles) {
            $styles_wf = array(
                'text-align',
                'margin',
                'color',
                'float',
                'border',
                'background',
                'background-color',
                'border-bottom',
                'border-bottom-color',
                'border-bottom-style',
                'border-bottom-width',
                'border-collapse',
                'border-color',
                'border-left',
                'border-left-color',
                'border-left-style',
                'border-left-width',
                'border-right',
                'border-right-color',
                'border-right-style',
                'border-right-width',
                'border-spacing',
                'border-style',
                'border-top',
                'border-top-color',
                'border-top-style',
                'border-top-width',
                'border-width',
                'caption-side',
                'clear',
                'cursor',
                'direction',
                'font',
                'font-family',
                'font-size',
                'font-style',
                'font-variant',
                'font-weight',
                'height',
                'letter-spacing',
                'line-height',
                'margin-bottom',
                'margin-left',
                'margin-right',
                'margin-top',
                'overflow',
                'padding',
                'padding-bottom',
                'padding-left',
                'padding-right',
                'padding-top',
                'text-decoration',
                'text-indent',
                'vertical-align',
                'width',
                'display',
            );

            foreach ($styles_wf as $style_wf) {
                $styles[] = $style_wf;
            }
            return $styles;
        });

        $allowed_tags = wp_kses_allowed_html('post');
        $allowed_tags['input'] = array(
            'type' => true,
            'style' => true,
            'class' => true,
            'id' => true,
            'checked' => true,
            'disabled' => true,
            'name' => true,
            'size' => true,
            'placeholder' => true,
            'value' => true,
            'data-*' => true,
            'size' => true,
            'disabled' => true
        );

        $allowed_tags['textarea'] = array(
            'type' => true,
            'style' => true,
            'class' => true,
            'id' => true,
            'checked' => true,
            'disabled' => true,
            'name' => true,
            'size' => true,
            'placeholder' => true,
            'value' => true,
            'data-*' => true,
            'cols' => true,
            'rows' => true,
            'disabled' => true,
            'autocomplete' => true
        );

        $allowed_tags['select'] = array(
            'type' => true,
            'style' => true,
            'class' => true,
            'id' => true,
            'checked' => true,
            'disabled' => true,
            'name' => true,
            'size' => true,
            'placeholder' => true,
            'value' => true,
            'data-*' => true,
            'multiple' => true,
            'disabled' => true
        );

        $allowed_tags['option'] = array(
            'type' => true,
            'style' => true,
            'class' => true,
            'id' => true,
            'checked' => true,
            'disabled' => true,
            'name' => true,
            'size' => true,
            'placeholder' => true,
            'value' => true,
            'selected' => true,
            'data-*' => true
        );
        $allowed_tags['optgroup'] = array(
            'type' => true,
            'style' => true,
            'class' => true,
            'id' => true,
            'checked' => true,
            'disabled' => true,
            'name' => true,
            'size' => true,
            'placeholder' => true,
            'value' => true,
            'selected' => true,
            'data-*' => true,
            'label' => true
        );

        $allowed_tags['a'] = array(
            'href' => true,
            'data-*' => true,
            'class' => true,
            'style' => true,
            'id' => true,
            'target' => true,
            'data-*' => true,
            'role' => true,
            'aria-controls' => true,
            'aria-selected' => true,
            'disabled' => true
        );

        $allowed_tags['div'] = array(
            'style' => true,
            'class' => true,
            'id' => true,
            'data-*' => true,
            'role' => true,
            'aria-labelledby' => true,
            'value' => true,
            'aria-modal' => true,
            'tabindex' => true
        );

        $allowed_tags['li'] = array(
            'style' => true,
            'class' => true,
            'id' => true,
            'data-*' => true,
            'role' => true,
            'aria-labelledby' => true,
            'value' => true,
            'aria-modal' => true,
            'tabindex' => true
        );

        $allowed_tags['span'] = array(
            'style' => true,
            'class' => true,
            'id' => true,
            'data-*' => true,
            'aria-hidden' => true
        );

        $allowed_tags['style'] = array(
            'class' => true,
            'id' => true,
            'type' => true,
            'style' => true
        );

        $allowed_tags['fieldset'] = array(
            'class' => true,
            'id' => true,
            'type' => true,
            'style' => true
        );

        $allowed_tags['link'] = array(
            'class' => true,
            'id' => true,
            'type' => true,
            'rel' => true,
            'href' => true,
            'media' => true,
            'style' => true
        );

        $allowed_tags['form'] = array(
            'style' => true,
            'class' => true,
            'id' => true,
            'method' => true,
            'action' => true,
            'data-*' => true,
            'style' => true
        );

        $allowed_tags['script'] = array(
            'class' => true,
            'id' => true,
            'type' => true,
            'src' => true,
            'style' => true
        );

        $allowed_tags['table'] = array(
            'class' => true,
            'id' => true,
            'type' => true,
            'cellpadding' => true,
            'cellspacing' => true,
            'border' => true,
            'style' => true
        );

        $allowed_tags['canvas'] = array(
            'class' => true,
            'id' => true,
            'style' => true
        );

        if(false === $return){
            echo wp_kses($html, $allowed_tags);
        } else {
            return wp_kses($html, $allowed_tags);
        }

        add_filter('safe_style_css', function ($styles) {
            $styles_wf = array(
                'text-align',
                'margin',
                'color',
                'float',
                'border',
                'background',
                'background-color',
                'border-bottom',
                'border-bottom-color',
                'border-bottom-style',
                'border-bottom-width',
                'border-collapse',
                'border-color',
                'border-left',
                'border-left-color',
                'border-left-style',
                'border-left-width',
                'border-right',
                'border-right-color',
                'border-right-style',
                'border-right-width',
                'border-spacing',
                'border-style',
                'border-top',
                'border-top-color',
                'border-top-style',
                'border-top-width',
                'border-width',
                'caption-side',
                'clear',
                'cursor',
                'direction',
                'font',
                'font-family',
                'font-size',
                'font-style',
                'font-variant',
                'font-weight',
                'height',
                'letter-spacing',
                'line-height',
                'margin-bottom',
                'margin-left',
                'margin-right',
                'margin-top',
                'overflow',
                'padding',
                'padding-bottom',
                'padding-left',
                'padding-right',
                'padding-top',
                'text-decoration',
                'text-indent',
                'vertical-align',
                'width'
            );

            foreach ($styles_wf as $style_wf) {
                if (($key = array_search($style_wf, $styles)) !== false) {
                    unset($styles[$key]);
                }
            }
            return $styles;
        });
    }
}
