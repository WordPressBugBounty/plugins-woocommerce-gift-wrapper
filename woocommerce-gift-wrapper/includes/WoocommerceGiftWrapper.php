<?php

namespace GiftWrapper;

use GiftWrapper\Blocks\GiftWrapperBlock;

defined('ABSPATH') or exit;

/**
 * Gift Wrapper initiator
 * This class will initiate other classes for the plugin to make settings and blocks available
 * 
 * @package GiftWrapper
 */
class WoocommerceGiftWrapper
{
    public function __construct()
    {
        new GiftWrapperBlock();
    }
}
