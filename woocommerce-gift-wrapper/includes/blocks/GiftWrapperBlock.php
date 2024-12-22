<?php

namespace GiftWrapper\Blocks;

defined('ABSPATH') or exit;

/**
 * Class GiftWrapperBlock
 * Created and handles resources for the Gift Wrapper block
 * 
 * @package GiftWrapper\Blocks
 */
class GiftWrapperBlock
{
    public function __construct()
    {
        add_action('init', [$this, 'register_block']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_assets']);
        add_action('enqueue_block_assets', [$this, 'enqueue_editor_assets']);
    }

    /**
     * Enqueue editor assets
     *
     * @return void
     */
    public function enqueue_editor_assets() : void
    {
        $screen_context = null;

        if(function_exists('get_current_screen')){
            $screen_context = get_current_screen();
        }
        
        if ($screen_context !== null && $screen_context->base === 'site-editor') {
            return;
        }
        
        if(!is_admin()){
            return;
        }

        $asset_props  = include GIFTWRAPPER_PATH . 'build/blocks/gift-wrapper/index.asset.php';
        wp_enqueue_script(
            'wcgwp-editor',
            plugins_url('build/blocks/gift-wrapper/index.js', GIFTWRAPPER_FILE),
            $asset_props['dependencies'],
            $asset_props['version'],
            true
        );
        wp_enqueue_style(
            'wcgw-editor', 
            plugins_url('build/blocks/gift-wrapper/style-index.css', GIFTWRAPPER_FILE),
            [],
            $asset_props['version']
        );
    }

    /**
     * Register the block for server side
     *
     * @return void
     */
    public function register_block() : void
    {
        register_block_type_from_metadata(
            GIFTWRAPPER_PATH . '/build/blocks/gift-wrapper',
            [
                'render_callback' => [$this, 'render']
            ]
        );
    }    

    /**
     * Render the block from wrapping classes
     *
     * @return string
     */
    public function render() : string
    {
        if(is_single() && !wcgw_fs()->is__premium_only()){
            return '';
        }

        ob_start();

        if(is_single()){
            WCGWP()->product->output_display();
        }else{
            WCGWP()->wrapping->gift_wrap_action('');
        }

        return ob_get_clean();
    }
}
