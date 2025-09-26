<?php

defined('ABSPATH') || exit;

if (class_exists('Gift_Wrapper_Settings_Page', false)) {
    return new Gift_Wrapper_Settings_Page();
}

class Gift_Wrapper_Settings_Page extends WC_Settings_Page
{

    /**
     * Constructor.
     */
    public function __construct()
    {

        $this->id = 'gift-wrapper';
        $this->label = __('Gift Wrapper', 'woocommerce-gift-wrapper');

        parent::__construct();

        add_action('admin_footer', array($this, 'admin_footer'));
    }

    function admin_footer()
    {
        $screen = get_current_screen();
        if ('woocommerce_page_wc-settings' !== $screen->id) {
            return;
        }
        if (empty($_GET['tab']) || 'gift-wrapper' !== $_GET['tab']) {
            return;
        }

        echo '<div id="gift-wrap-pro-dialog" style="display:none;" title="Gift Wrapper PRO is here!"><span class="ui-helper-hidden-accessible"><input type="text"/></span>

        <div class="center logo"><a href="https://www.giftwrapper.app/?ref=gift-wrap-free-pricing-table" target="_blank"><img width="64" src="' . esc_url(GIFTWRAPPER_URL . '/assets/img/gift-wrapper-logo.png') . '" alt="Gift Wrapper PRO" title="Gift Wrapper PRO"> Gift Wrapper PRO</a><br>

        <span>Limited PRO Discount - <b>personal license is LIFETIME</b>! Pay once &amp; use forever!</span>
        </div>

        <table id="gift-wrap-pro-table">
        <tr>
        <td class="center">Lifetime Personal License</td>
        <td class="center">Yearly Team License</td>
        <td class="center">Yearly Agency License</td>
        </tr>

        <tr class="prices">
        <td class="center"><del>$49 /year</del><br><span>$89</span> <b>/lifetime</b></td>
        <td class="center">&nbsp;<br><span>$89</span> <b>/year</b></td>
        <td class="center">&nbsp;<br><span>$159</span> <b>/year</b></td>
        </tr>

        <tr>
        <td><span class="dashicons dashicons-yes"></span><b>1 Site License</b></td>
        <td><span class="dashicons dashicons-yes"></span><b>5 Sites License</b></td>
        <td><span class="dashicons dashicons-yes"></span><b>100 Sites License</b></td>
        </tr>

        <tr>
        <td><span class="dashicons dashicons-yes"></span>All Plugin Features</td>
        <td><span class="dashicons dashicons-yes"></span>All Plugin Features</td>
        <td><span class="dashicons dashicons-yes"></span>All Plugin Features</td>
        </tr>

        <tr>
        <td><span class="dashicons dashicons-yes"></span>Easy GUI Translations</td>
        <td><span class="dashicons dashicons-yes"></span>Easy GUI Translations</td>
        <td><span class="dashicons dashicons-yes"></span>Easy GUI Translations</td>
        </tr>

        <tr>
        <td><span class="dashicons dashicons-yes"></span>Per Product Wrap Options</td>
        <td><span class="dashicons dashicons-yes"></span>Per Product Wrap Options</td>
        <td><span class="dashicons dashicons-yes"></span>Per Product Wrap Options</td>
        </tr>

        <tr>
        <td><span class="dashicons dashicons-yes"></span>Stock Control</td>
        <td><span class="dashicons dashicons-yes"></span>Stock Control</td>
        <td><span class="dashicons dashicons-yes"></span>Stock Control</td>
        </tr>

        <tr>
        <td><span class="dashicons dashicons-yes"></span>Modal Animations</td>
        <td><span class="dashicons dashicons-yes"></span>Modal Animations</td>
        <td><span class="dashicons dashicons-yes"></span>Modal Animations</td>
        </tr>

        <tr>
        <td><span class="dashicons dashicons-yes"></span>Lifetime Updates &amp; Support</td>
        <td><span class="dashicons dashicons-yes"></span>1 Year Updates &amp; Support</td>
        <td><span class="dashicons dashicons-yes"></span>1 Year Updates &amp; Support</td>
        </tr>

        <tr>
        <td><a class="button button-buy" data-href-org="https://www.giftwrapper.app/buy/?product=personal-lifetime&ref=pricing-table" href="https://www.giftwrapper.app/buy/?product=personal-lifetime&ref=pricing-table" target="_blank">Lifetime License<br>$89 -&gt; BUY NOW</a>
        <br>or <a class="button-buy" data-href-org="https://www.giftwrapper.app/buy/?product=personal-yearly&ref=pricing-table" href="https://www.giftwrapper.app/buy/?product=personal-yearly&ref=pricing-table" target="_blank">only $49 <small>/year</small></a></td>
        <td><a class="button button-buy" data-href-org="https://www.giftwrapper.app/buy/?product=team-yearly&ref=pricing-table" href="https://www.giftwrapper.app/buy/?product=team-yearly&ref=pricing-table" target="_blank">Yearly License<br>$89 -&gt; BUY NOW</a></td>
        <td><a class="button button-buy" data-href-org="https://www.giftwrapper.app/buy/?product=agency-yearly&ref=pricing-table" href="https://www.giftwrapper.app/buy/?product=agency-yearly&ref=pricing-table" target="_blank">Yearly License<br>$159 -&gt; BUY NOW</a></td>
        </tr>

        </table>

        <div class="center footer"><b>100% No-Risk Money Back Guarantee!</b> If you don\'t like the plugin over the next 7 days, we will happily refund 100% of your money. No questions asked! Payments are processed by our merchant of records - <a href="https://paddle.com/" target="_blank">Paddle</a>.

        </div>';
    }
    /**
     * Set Gift Wrapper tab sections.
     *
     * @return array
     */
    protected function get_own_sections()
    {

        return [
            ''                  => __('General Options', 'woocommerce-gift-wrapper'),
            'order_wrapping'    => __('Order Wrapping', 'woocommerce-gift-wrapper'),
			'product_wrapping'  => __('Product Wrapping', 'woocommerce-gift-wrapper-pro' ),
            'language'          => __('Language / Translations', 'woocommerce-gift-wrapper'),
            'more_info'         => __('More Info', 'woocommerce-gift-wrapper'),
        ];
    }

    /**
     * Get default (general options) settings array
     *
     * @return array
     */
    public function get_settings_for_default_section()
    {

        $settings[] = [
            'name'          => __('Setup Instructions', 'woocommerce-gift-wrapper'),
            'type'          => 'title',
            'desc'          => '<p style="color:#135e96;font-size:20px"><strong>For more advanced options get the PRO version. &nbsp; <a href="#" class="button button-primary open-upsell" rel="noopener" target="_blank" data-feature="upgrade-btn-lifetime">Get a discounted lifetime license</a></strong></p><strong>1.</strong> '
                /* translators: %s is the URL of the Product Categories page */
                . sprintf(__('Create a new, unique <a href="%s" target="_blank" rel="noopener">WooCommerce product category</a> to hold your gift wrap product(s). Name it anything you\'d like.', 'woocommerce-gift-wrapper'), admin_url('/edit-tags.php?taxonomy=product_cat&post_type=product'))
                /* translators: %s is the URL of the New Product page */
                . '<br /><strong>2.</strong> ' . wp_kses_post(sprintf(__('Create at least one <a href="%s" target="_blank">WooCommerce product</a> to represent your gift wrap or add-on.', 'woocommerce-gift-wrapper'), admin_url('post-new.php?post_type=product')))
                . '<br /> &nbsp; &nbsp; &nbsp; &nbsp; ' . __('Give the product a title and a price. It must have a price set, even if at 0. It can be hidden from the catalog if you like, but shouldn\'t be private.', 'woocommerce-gift-wrapper')
                . '<br /><strong>3.</strong> ' . __('Add the product(s) from step 2 to your new, unique WooCommerce product category from step 1.', 'woocommerce-gift-wrapper')
                . '<br /><strong>4.</strong> ' . sprintf(__('Change the "<a href="#" id="wcgwp-wrap-category-link">Gift wrap category</a>" setting below to the product category created in step 1, and save.', 'woocommerce-gift-wrapper')
                    /* translators: %s is the URL of the Gift Wrapper settings page */
                    . '<br /><strong>5.</strong> ' . __('Review all the settings below, then finish on the <a href="%s" rel="noopener">Order Wrapping</a> options page.', 'woocommerce-gift-wrapper'), admin_url('admin.php?page=wc-settings&tab=gift-wrapper&section=order_wrapping')),
        ];
        $settings[]    = [
            'id'            => 'wcgwp_category_id',
            'title'         => __('Gift wrap category', 'woocommerce-gift-wrapper'),
            'desc_tip'      => __('Define the category which holds your gift wrap product(s), e.g. your boxes, bags, and gift paper product(s).', 'woocommerce-gift-wrapper'),
            'type'          => 'select',
            'default'       => 'none',
            'options'       => WC_Gift_Wrap()->settings->product_cats(),
            'custom_attributes' => [
                'data-placeholder' => __('Define a Category', 'woocommerce-gift-wrapper')
            ],
            'class'         => 'chosen_select',
            'autoload'      => false,
        ];

        $settings[] = [
            'id'       => 'wcgwp_multiples',
            'name'     => __('Allow multiples? (PRO)', 'woocommerce-gift-wrapper-pro'),
            'desc'     => __('Check to allow more than one giftwrap to be added to a product.', 'woocommerce-gift-wrapper-pro'),
            'type'     => 'checkbox',
            'default'  => 'no',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'class'    => 'wcgwp-pro',
            'autoload' => false,
        ];

        $settings[] = [
            'id'            => 'wcgwp_textarea_limit',
            'name'          => __('Textarea character limit', 'woocommerce-gift-wrapper'),
            'desc'          => __('Set to 0 (zero) to hide the textarea', 'woocommerce-gift-wrapper'),
            'desc_tip'      => __('How many characters your customer can type when creating their own note for giftwrapping. Defaults to 1000 characters; lower this number if you want shorter notes from your customers.', 'woocommerce-gift-wrapper'),
            'type'          => 'number',
            'default'       => 1000,
            'autoload'      => false,
        ];

        $settings[] = [
            'id'       => 'wcgwp_hide_price',
            'name'     => __('Hide price? (PRO)', 'woocommerce-gift-wrapper-pro'),
            'desc_tip' => __('Should the gift wrap price be hidden? Tip: the price HTML can also be filtered using the \'wcgwp_price_html\' hook.', 'woocommerce-gift-wrapper-pro'),
            'type'     => 'select',
            'default'  => 'no',
            'options'  => [
                'yes' => __('Yes', 'woocommerce-gift-wrapper-pro'),
                'no'  => __('No', 'woocommerce-gift-wrapper-pro'),
            ],
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'class'    => 'wcgwp-pro',
            'autoload' => false,
        ];
        $settings[] = [
            'id'       => 'wcgwp_note_fee',
            'name'     => __('Add fee? (PRO)', 'woocommerce-gift-wrapper-pro'),
            'desc_tip' => __('Do you wish to charge a fee for customers to add a note to their gift wrapping?', 'woocommerce-gift-wrapper-pro'),
            'type'     => 'select',
            'default'  => 'no',
            'options'  => [
                'yes' => __('Yes', 'woocommerce-gift-wrapper-pro'),
                'no'  => __('No', 'woocommerce-gift-wrapper-pro'),
            ],
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'class'    => 'wcgwp-pro',
            'autoload' => false,
        ];
        $settings[] = [
            'id'       => 'wcgwp_note_fee_amount',
            'name'     => __('Fee amount (PRO)', 'woocommerce-gift-wrapper-pro'),
            'desc_tip' => __('Enter the amount you wish to charge to include a note, e.g. 1.00 or 2.50', 'woocommerce-gift-wrapper-pro'),
            'type'     => 'text',
            'default'  => '0.00',
            'class'    => 'wcgwp-pro',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload' => false,
        ];

        $settings[] = [
            'type'  => 'sectionend'
        ];

        $settings[] = [
            'id'   => 'wcgwp_modal_title',
            'name' => __('Modal Options', 'woocommerce-gift-wrapper-pro'),
            'type' => 'title',
            'desc' => __('We see you have chosen to use a modal (pop-up) to display your wrap. Would you like to animate your modals?', 'woocommerce-gift-wrapper-pro'),
        ];
        $settings[] = [
            'id'       => 'wcgwp_modal_animate',
            'name'     => __('Animate modals? (PRO)', 'woocommerce-gift-wrapper-pro'),
            'type'     => 'checkbox',
            'default'  => 'no',
            'desc'     => wp_kses_post(sprintf(__('Check to animate modals using <a href="%s" target="_blank" rel="noopener">animate.css</a>. Will automatically include extra necessary CSS file and Javascript in pages where modals show.', 'woocommerce-gift-wrapper-pro'), 'https://animate.style')),
            'desc_tip' => __('You can also choose to instead customize/animate your modals as you choose by overriding included template files.', 'woocommerce-gift-wrapper-pro'),
            'class'    => 'wcgwp-pro',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload' => false,
        ];

        $settings[] = [
            'type' => 'sectionend',
        ];

        $settings[] = [
            'name'          => __('Advanced Options', 'woocommerce-gift-wrapper'),
            'type'          => 'title',
            'desc'          => '',
        ];
        $settings[] = [
            'id'                => 'wcgwp_lt6_templates',
            'name'              => __('Accommodate templates from version 5?', 'woocommerce-gift-wrapper'),
            'type'              => 'checkbox',
            'default'           => 'no',
            'desc'              => __('Version 6.0 of Gift Wrapper includes many template adjustments, and uses AJAX in the cart/checkout instead of a form submit.<br />If you have overwritten the plugin templates with customizations before 6.0 and things broke for you with the 6.0 update, check this box until you can update your templates.', 'woocommerce-gift-wrapper'),
            'autoload'          => false
        ];

        $settings[] = [
            'id'            => 'wcgwp_delete_all',
            'name'          => __('Leave No Trace', 'woocommerce-gift-wrapper'),
            'type'          => 'checkbox',
            'default'       => 'yes',
            'desc'          => __('Delete all settings upon plugin uninstall', 'woocommerce-gift-wrapper'),
            'desc_tip'      => __('If you plan on deleting this plugin and not coming back, and want to keep your Wordpress database tables tidy, check this box, save settings, then delete the plugin.', 'woocommerce-gift-wrapper'),
            'autoload'      => false
        ];

        $settings[] = [
            'type' => 'sectionend'
        ];

        return $settings;
    }

    /**
	 * Get product wrapping settings array
	 *
	 * @return array
	 */
	public function get_settings_for_product_wrapping_section() {

			$settings[] = [
				'name'              => __( 'Product Gift Wrapping Settings', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'title',
				'desc'              => __( 'Whereas Order gift wrapping is non-specific and generally applies to an entire WooCommerce order,', 'woocommerce-gift-wrapper-pro' )
									. '<br />' . __( 'these Product Gift Wrapping settings allow more granular control over what products can be wrapped.', 'woocommerce-gift-wrapper-pro' )
									. '<br />' . wp_kses_post( sprintf( __( 'Note: To begin, a product category to include/represent your gift wrap product(s) will need to be set under the "<a href="%s" rel="noopener">General Options</a>" tab.', 'woocommerce-gift-wrapper-pro' ), admin_url( 'admin.php?http://localhost:8888/wp-admin/admin.php?page=wc-settings&tab=gift-wrapper-pro&section=general_options' )  )),
			];
			$settings[] = [
				'id'                => 'wcgwp_all_products',
				'name'              => __( 'Gift wrapping (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc'              => __( 'Enable Gift Wrap for All Products', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'If you check this box, gift wrapping will be enabled for your entire catalog, except for any excluded product categories, or individually excluded products.', 'woocommerce-gift-wrapper-pro' )
									. '<br />' . __( 'If this is not checked and you wish for per-product wrap control, you will need to enable wrap in the product settings for products you wish wrapped.', 'woocommerce-gift-wrapper-pro' )
									. '<br />' . __( 'If this is not checked and wrapping is not turned on for any individual products, no per-product wrapping will be offered.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'checkbox',
				'default'           => 'no',
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false
			];
			$settings[]	= [
				'id'                => 'wcgwp_product_category_id',
				'title'             => __( 'Product page wrap category (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( '(Optional) Set a wrapping category to apply to single products. Can be overwritten in Woo single product settings. If not set, the gift wrap category in General Options applies.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'none',
				'options'           => WCGWP()->settings->product_cats(),
				'class'             => 'chosen_select',
				'custom_attributes' => [
					'data-placeholder' => __( 'Define a Category', 'woocommerce-gift-wrapper-pro' ),
                    'disabled' => 'disabled',
				],
				'autoload'          => false,
			];
			$settings[] = [
				'id'                => 'wcgwp_exclude_cats',
				'name'              => __( 'Exclude product categories', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'Choose product categories to exclude from gift wrapping. You may choose more than one. You can exclude products individually using their Woo product settings pages. You do not need to exclude your gift wrap category.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'multiselect',
				'options'           => WCGWP()->settings->product_cats( 'exclusions' ),
				'class'             => 'chosen_select',
				'custom_attributes' => [
					'data-placeholder'  => __( 'Exclude these categories (optional)', 'woocommerce-gift-wrapper-pro' )
				],
				'autoload'          => false,
			];
			$settings[] = [
				'id'                => 'wcgwp_product_show_thumb',
				'name'              => __( 'Show thumbnails? (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'Should gift wrap product thumbnail images be visible on product pages?', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'yes',
				'options'           => [
					'yes'               => __( 'Yes', 'woocommerce-gift-wrapper-pro' ),
					'no'                => __( 'No', 'woocommerce-gift-wrapper-pro' ),
				],
				'class'             => 'wcgwp-product-show-thumb',
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false,
			];
			$settings[] = [
				'id'                => 'wcgwp_product_link',
				'name'              => __( 'Link thumbnails? (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'Should thumbnail images link to gift wrap product details on product pages? (This setting does nothing inside "alt" style modals.)', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'no',
				'options'           => [
					'yes'               => __( 'Yes', 'woocommerce-gift-wrapper-pro' ),
					'no'                => __( 'No', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'class'             => 'wcgwp-product-link',
				'autoload'          => false,
			];

			$settings[] = [
				'id'                => 'wcgwp_product_ratio',
				'name'              => __( 'Wrap Quantities (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( '(Beta setting) Dictate how many giftwraps can be in cart for each line item product. Works best with cart item wrapping; loose control with attribute wrapping.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'ad-lib',
				'options'           => [
					'ad-lib'            => __( 'Any quantity of wrap', 'woocommerce-gift-wrapper-pro' ),
					'one-to-one'        => __( 'One-to-one wrap per product', 'woocommerce-gift-wrapper-pro' ),
					'only-one'          => __( 'One wrap per product', 'woocommerce-gift-wrapper-pro' ),
					'up-to-item-qty'    => __( 'Up to parent item quantity', 'woocommerce-gift-wrapper-pro' ),
					'up-to-cart-qty'    => __( 'Up to total quantity of products in cart', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false,
			];

			$settings[] = [
				'id'                => 'wcgwp_over_ratio_response',
				'name'              => __( 'Response when over ratio (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'If a customer requests more wrap be added than the product/cart should have, how do we proceed? Warning/feedback will be given to the customer in either case.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'none',
				'options'           => [
					'none'  => __( 'Add none to cart', 'woocommerce-gift-wrapper-pro' ),
					'some'  => __( 'Add some to cart', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false,
			];

			$settings[] = [
				'id'                => 'wcgwp_cant_wrap_cue',
				'name'              => __( 'Cue when unwrappable? (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'If an item cannot be wrapped, should text be shown to alert the customer? This text can be translated on the strings page (link above) or by using filters.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'no',
				'options'           => [
					'yes'               => __( 'Yes', 'woocommerce-gift-wrapper-pro' ),
					'no'                => __( 'No', 'woocommerce-gift-wrapper-pro' ),
					'product'           => __( 'Product page only', 'woocommerce-gift-wrapper-pro' ),
					'cartitem'          => __( 'Inside cart only', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false,
			];
			$settings[] = [
				'id'                => 'wcgwp_show_relationship',
				'name'              => __( 'Show relationship? (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'You have chosen gift wrapping as its own cart item. Should the cart item show a more obvious relationship to the product it wraps, in the cart?', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'no',
				'options'           => [
					'yes'               => __( 'Yes', 'woocommerce-gift-wrapper-pro' ),
					'no'                => __( 'No', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false,
			];
			$settings[] = [
				'type' => 'sectionend',
			];

			$settings[] = [
				'name'              => __( 'Wrap on Product pages', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'title',
			];
			$settings[] = [
				'id'                => 'wcgwp_per_product_type',
				'name'              => __( 'Gift wrap from product pages? (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'Should product gift wrap be offered from product pages, and if so, as an attribute of parent product or its own line item when added to cart? If an attribute, separate tax rates cannot be used and gift wrap will not be inventoried.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'none',
				'options'           => [
					'no'                => __( 'No', 'woocommerce-gift-wrapper-pro' ),
					'cartitem'          => __( 'Yes - Cart Item', 'woocommerce-gift-wrapper-pro' ),
					'attribute'         => __( 'Yes - as a Product Attribute', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false,
			];

			$settings[] = [
				'id'                => 'wcgwp_product_hook',
				'name'              => __( 'Gift wrap prompt location (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'Choose where to show gift wrap options to the customer on the product page. We recommend "Before Add to Cart." You may choose more than one.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'multiselect',
				'default'           => 'woocommerce_before_add_to_cart_button',
				'options'           => [
					'woocommerce_before_add_to_cart_button' => __( 'Before Add to Cart Button', 'woocommerce-gift-wrapper-pro' ),
					'woocommerce_after_add_to_cart_button'  => __( 'After Add to Cart Button', 'woocommerce-gift-wrapper-pro' ),
					'other'                                 => __( 'Other, specify below:', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'css'               => 'min-width:300px;',
				'autoload'          => false,
			];
			$settings[] = [
				'id'                => 'wcgwp_other_product_hook',
				'name'              => __( 'Other location', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'Name a valid WP hook inside your product pages where a gift wrap prompt should attach. More than one? Separate with commas.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'text',
				'default'           => '',
				'autoload'          => false,
			];
			$settings[] = [
				'id'                => 'wcgwp_product_display',
				'name'              => __( 'Choose opt-in display type (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'A slide-down menu of options appears on the page (almost from out of nowhere) when a user asks to wrap. If modal, when gift wrap links are clicked, they will open a window for customers to choose gift wrapping options. It can be styled and might be a nicer option for your site; however a simple checkbox can be just as effective.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'modal',
				'options'           => [
					'modal'             => __( 'Modal/Popup', 'woocommerce-gift-wrapper-pro' ),
					'alt'               => __( 'Modal/Popup - alternate style', 'woocommerce-gift-wrapper-pro' ),
					'slide'             => __( 'SlideToggle - uses jQuery', 'woocommerce-gift-wrapper-pro' ),
					'checkbox'          => __( 'Checkbox', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false,
			];
			$settings[] = [
				'id'                => 'wcgwp_product_checkbox_link',
				'name'              => __( 'Link checkbox label? (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'Should the checkbox label product title link to its WC product page?', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'no',
				'options'           => [
					'yes'               => __( 'Yes', 'woocommerce-gift-wrapper-pro' ),
					'no'                => __( 'No', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'      => false,
			];
			$settings[] = [
				'type'              => 'sectionend',
			];

			$settings[] = [
				'name'              => __( 'Per-product wrap inside Cart', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'title',
			];
			$settings[] = [
				'id'                => 'wcgwp_cart_item_type',
				'name'              => __( 'Wrap products shown inside cart? (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'Enables gift wrap inside the cart, per product. The customer will be able to add giftwrapping to products during checkout, except for any excluded product categories, or individually excluded products. Cart item wrap will sit on its own line. Attribute wrap becomes an Woo product attribute of the wrapped product.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'no',
				'options'           => [
					'no'                => __( 'No', 'woocommerce-gift-wrapper-pro' ),
					'cartitem'          => __( 'Yes - as a Cart Item', 'woocommerce-gift-wrapper-pro' ),
					'attribute'         => __( 'Yes - as a Product Attribute', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false,
			];
			$settings[] = [
				'id'                => 'wcgwp_cart_item_display',
				'name'              => __( 'Choose opt-in display type (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'If modal, when gift wrap links are clicked, they will open a separate, floating window for customers to choose gift wrapping options. It can be styled and might be a nicer option for your site.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'yes',
				'options'           => [
					'modal'             => __( 'Modal/Popup', 'woocommerce-gift-wrapper-pro' ),
					'alt'               => __( 'Modal/Popup - alternate style', 'woocommerce-gift-wrapper-pro' ),
					'slide'             => __( 'SlideToggle - uses jQuery', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false,
			];
			$settings[] = [
				'id'                => 'wcgwp_wrap_remove',
				'name'              => __( 'Allow customer to remove wrap from product in cart? (PRO)', 'woocommerce-gift-wrapper-pro' ),
				'desc_tip'          => __( 'Remove gift wrapping attribute without deleting the whole wrapped product from the cart.', 'woocommerce-gift-wrapper-pro' ),
				'type'              => 'select',
				'default'           => 'yes',
				'options'           => [
					'yes'               => __( 'Yes', 'woocommerce-gift-wrapper-pro' ),
					'no'                => __( 'No', 'woocommerce-gift-wrapper-pro' ),
				],
                'custom_attributes' => [
                    'disabled' => 'disabled',
                ],
				'autoload'          => false,
				'class'             => 'wcgwp_wrap_remove',
			];
			$settings[] = [
				'type' => 'sectionend',
			];

		return $settings;

	}

    /**
     * Get order wrapping settings array
     *
     * @return array
     */
    public function get_settings_for_order_wrapping_section()
    {

        $settings[] = [
            'name' => __('Order Gift Wrapping Settings', 'woocommerce-gift-wrapper'),
            'type' => 'title',
            'desc' => __(' <p style="color:#135e96;font-size:20px"><strong>Get per-product settings. &nbsp; <a href="#" class="button button-primary open-upsell" rel="noopener" target="_blank" data-feature="upgrade-btn-only-49">Upgrade for only $49 <small>/y</small></a></strong></p> These settings apply to per-order wrap options in the cart and checkout areas, not cart item (per-item) or per-product wrapping.', 'woocommerce-gift-wrapper')
                . '<br />'
                /* translators: %s is the URL of the Gift Wrapper plugin website */
                . wp_kses_post(sprintf(__('Per-product and cart item (inside the cart) gift wrapping options are available in the <a href="%s" target="_blank" class="open-upsell" rel="noopener">PLUS version of this plugin.</a>', 'woocommerce-gift-wrapper'), '#')),
        ];
        $settings[] = [
            'id'       => 'wcgwp_cart_hook',
            'name'     => __('Gift wrap prompt location', 'woocommerce-gift-wrapper'),
            'desc_tip' => __('Choose where to show gift wrap options to the customer on the cart page. You may choose more than one. Set to "none" to both temporarily hide your wrap and keep your settings for later.', 'woocommerce-gift-wrapper'),
            'type'     => 'multiselect',
            'default'  => 'none',
            'options'  => WC_Gift_Wrap()->settings->get_placements(),
            'css'      => 'min-height:110px',
            'autoload' => false
        ];
        $settings[] = [
            'id'       => 'wcgwp_cart_display',
            'name'     => __('How should options be displayed?', 'woocommerce-gift-wrapper'),
            'desc_tip' => __('If modal or slideToggle, there will be a prompt link ("header") in the cart, which when clicked will open a panel for customers to choose gift wrapping options. Checkbox and alternative modal display options available in the PLUS (paid) version.', 'woocommerce-gift-wrapper'),
            'type'     => 'select',
            'default'  => 'modal',
            'options'  => [
                'modal'     => __('Modal/Popup', 'woocommerce-gift-wrapper'),
                'slide'     => __('SlideToggle - uses jQuery', 'woocommerce-gift-wrapper'),
                'checkbox'  => __('Checkbox', 'woocommerce-gift-wrapper'),
            ],
            'autoload' => false
        ];
        $settings[] = [
            'id'        => 'wcgwp_checkbox_link',
            'name'      => __('Link checkbox label?', 'woocommerce-gift-wrapper'),
            'desc_tip'  => __('Should the checkbox label product title link to its WC product page?', 'woocommerce-gift-wrapper'),
            'type'      => 'select',
            'default'   => 'no',
            'options'   => [
                'yes'       => __('Yes', 'woocommerce-gift-wrapper'),
                'no'        => __('No', 'woocommerce-gift-wrapper'),
            ],
            'autoload'  => false,
        ];
        $settings[] = [
            'id'       => 'wcgwp_show_thumb',
            'name'     => __('Show thumbnails?', 'woocommerce-gift-wrapper'),
            'desc_tip' => __('Should gift wrap product thumbnail images be visible in the cart?', 'woocommerce-gift-wrapper'),
            'type'     => 'select',
            'default'  => 'yes',
            'options'  => [
                'yes' => __('Yes', 'woocommerce-gift-wrapper'),
                'no'  => __('No', 'woocommerce-gift-wrapper'),
            ],
            'autoload' => false,
        ];
        $settings[] = [
            'id'       => 'wcgwp_link',
            'name'     => __('Link thumbnails?', 'woocommerce-gift-wrapper'),
            'desc_tip' => __('Should thumbnail images link to gift wrap product details?', 'woocommerce-gift-wrapper'),
            'type'     => 'select',
            'default'  => 'no',
            'options'  => [
                'yes' => __('Yes', 'woocommerce-gift-wrapper'),
                'no'  => __('No', 'woocommerce-gift-wrapper'),
            ],
            'autoload' => false
        ];
        $settings[] = [
            'id'       => 'wcgwp_number',
            'name'     => __('Allow more than one gift wrap product in cart?', 'woocommerce-gift-wrapper'),
            'desc_tip' => __('If yes, customers can buy more than one gift wrapping product in one order.', 'woocommerce-gift-wrapper'),
            'type'     => 'select',
            'default'  => 'no',
            'options'  => [
                'yes'               => __('Yes', 'woocommerce-gift-wrapper'),
                'no'                => __('No', 'woocommerce-gift-wrapper'),
            ],
            'autoload' => false
        ];
        $settings[] = [
			'id'                => 'wcgwp_hide_peri_wrap',
			'name'              => __( 'Hide prompts if wrap already in cart? (PRO)', 'woocommerce-gift-wrapper-pro' ),
			'desc_tip'          => __( 'If there is any wrap in the cart (demonstrating that customer is aware wrapping is available) should prompts in cart/checkout area be hidden?', 'woocommerce-gift-wrapper-pro' ),
			'type'              => 'select',
			'default'           => 'no',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
			'options'           => [
				'yes'               => __( 'Yes', 'woocommerce-gift-wrapper-pro' ),
				'no'                => __( 'No', 'woocommerce-gift-wrapper-pro' ),
			],
			'autoload'          => false,
		];
        $settings[] = [
            'type' => 'sectionend'
        ];

        return $settings;
    }

    /**
     * Get "more info" section settings array
     *
     * @return void
     */
    public function output_more_info_screen()
    { ?>

        <div class="wcgwp-donation">
            <p style="color:#135e96;font-size:20px"><strong>Get priority email support from the plugin's developers. &nbsp; <a href="" class="button button-primary open-upsell" rel="noopener" target="_blank" data-feature="upgrade-btn-support">Upgrade for only $49 <small>/y</small>!</a></strong></p>
            <h2>Need more features?</h2>
            <p>
                If you need more features and functionality such as per-product wrap options, check out the PLUS version of The Gift Wrapper plugin. <a href="#" class="open-upsell" target="_blank" rel="noopener">Upgrade now!</a>
            </p>
            <h2>Need help?</h2>
            <p>
                Support via email is reserved for PRO (paying) users only - <a href="https://www.giftwrapper.app/" target="_blank">get PRO now</a>. Please refer to the <a href="https://wordpress.org/plugins/woocommerce-gift-wrapper/#faq-header" target=_blank" rel="noopener">FAQ</a> and <a href="https://wordpress.org/support/plugin/woocommerce-gift-wrapper/" target="_blank" rel="noopener nofollow">support forum</a> where your question might already be answered. <a href="https://wordpress.org/support/topic/before-you-post-please-read/" rel="https://wordpress.org/support/topic/before-you-post-please-read/">Read this before posting</a>.
            </p>
        </div>

<?php }


    /**
     * Get language settings array
     *
     * @return array
     */
    public function get_settings_for_language_section()
    {

        $settings[] = [
            'name'              => '',
            'type'              => 'title',
            'id'                => 'wcgwp-plus-only-lang',
            /* translators: %s is the URL of the Gift Wrapper plugin website */
            'desc'              => '<p style="color:#135e96;font-size:20px"><strong>' . sprintf(wp_kses(__('Easy translation to your language is available in the PLUS version of Gift Wrapper. &nbsp; <a href="%s" class="button button-primary open-upsell pro-label" rel="noopener" target="_blank" data-feature="upgrade-btn-49">Upgrade now for only $49 <small>/y</small>!</a>', 'woocommerce-gift-wrapper'), ['a' => ['href' => [], 'target' => [], 'rel' => [], 'class' => ['btn', 'button']]]), '#') . '</strong></p>',
        ];
        $settings[] = [
            'type' => 'sectionend'
        ];

        $settings[] = [
            'name'              => __('Language Matters', 'woocommerce-gift-wrapper'),
            'type'              => 'title',
            'desc'              => __('Enter your adjustments or translations in the fields at right. Defaults are shown at left.', 'woocommerce-gift-wrapper')
                . __(' To make text disappear on the front end, you may need to use CSS (e.g. {style="display:none"} ), to hide enclosing elements. To use HTML, you will need to override included plugin template files.', 'woocommerce-gift-wrapper'),
        ];

        $settings[] = [
            'id'                => 'wcgwp_strings[wrap_details]',
            'name'              => __('We offer the following gift wrap options:', 'woocommerce-gift-wrapper'),
            'desc'              => __('Optional text to give any details or conditions of your gift wrap', 'woocommerce-gift-wrapper'),
            'type'              => 'textarea',
            'css'               => 'height: 75px;',
            'default'           => 'We offer the following gift wrap options:',
        ];

        $settings[] = [
            'id'                => 'wcgwp_strings[wrap]',
            'name'              => __('Gift wrap (PRO)', 'woocommerce-gift-wrapper'),
            'type'              => 'text',
            'default'           => 'Gift wrap',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload'          => false
        ];
        $settings[] = [
            'id'                => 'wcgwp_strings[add_wrap_prompt]',
            'name'              => __('Add gift wrap? (PRO)', 'woocommerce-gift-wrapper'),
            'type'              => 'text',
            'default'           => 'Add gift wrap?',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
        ];
        $settings[] = [
            'id'                => 'wcgwp_strings[add_wrap_message]',
            'name'              => __('Add Gift Wrap Message: (PRO)', 'woocommerce-gift-wrapper'),
            'type'              => 'text',
            'default'           => 'Add Gift Wrap Message:',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload'          => false
        ];
        $settings[] = [
            'id'                => 'wcgwp_strings[add_wrap_to_order]',
            'name'              => __('Add Gift Wrap to Order: (PRO)', 'woocommerce-gift-wrapper'),
            'type'              => 'text',
            'default'           => 'Add Gift Wrap to Order:',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload'          => false
        ];
        $settings[] = [
            'id'                => 'wcgwp_strings[cancel]',
            'name'              => __('Cancel (PRO)', 'woocommerce-gift-wrapper'),
            'type'              => 'text',
            'default'           => 'Cancel',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload'          => false
        ];
        $settings[] = [
            'id'                => 'wcgwp_strings[cancel_wrap]',
            'name'              => __('Cancel gift wrap (PRO)', 'woocommerce-gift-wrapper'),
            'type'              => 'text',
            'default'           => 'Cancel gift wrap',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload'          => false
        ];
        $settings[] = [
            'id'                => 'wcgwp_strings[add_wrap_for_x]',
            /* translators: %s is replaced with product name */
            'name'              => __('Add gift wrapping for %s? (PRO)', 'woocommerce-gift-wrapper'),
            'type'              => 'text',
            'default'           => 'Add gift wrapping for %s?',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload'          => false
        ];
        $settings[] = [
            'id'                => 'wcgwp_strings[add_x_for_x]',
            /* translators: %1$s is the Wrapper name, %2$s is the product name */
            'name'              => __('Add %1$s for %2$s? (PRO)', 'woocommerce-gift-wrapper'),
            'type'              => 'text',
            'default'           => 'Add %s for %s?',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload'          => false
        ];
        $settings[] = [
            'id'                => 'wcgwp_strings[wrap_limit]',
            /* translators: %1$s is the quantity (literal like one, two), %2$s is the wrapper name */
            'name'              => __('You can only add %1$s %2$s to your cart (PRO)', 'woocommerce-gift-wrapper'),
            'type'              => 'text',
            'default'           => 'You can only add %s %s to your cart.',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload'          => false
        ];

        $settings[] = [
            'id'                => 'wcgwp_strings[note]',
            'name'              => __('Note (PRO)', 'woocommerce-gift-wrapper'),
            'type'              => 'text',
            'default'           => 'Note',
            'custom_attributes' => [
                'disabled' => 'disabled',
            ],
            'autoload'          => false
        ];
        $settings[] = [
            'type'  => 'sectionend'
        ];

        return $settings;
    }

    /**
     * Output the settings.
     */
    public function output()
    {

        global $current_section, $hide_save_button;

        if ('more_info' === $current_section) {
            $this->output_more_info_screen();
            $hide_save_button = true;
        }
        $settings = $this->get_settings_for_section($current_section);



        WC_Admin_Settings::output_fields($settings);
    }
}
