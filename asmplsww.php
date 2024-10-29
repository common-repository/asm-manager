<?php
/*
  Plugin Name: Advanced Shipping Manager
  Plugin URI: http://wordpress.org/plugins/asm
  Description: Advanced Shipping Manager Integration
  Author: ASM
  Developer: ASM
  Version: 1.2.7
  WC requires at least: 7.0.0
  WC tested up to: 9.1.4
  Author URI: https://www.advancedshippingmanager.com
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    if (!class_exists('ASMPLSWW_Admin')) {
        include_once 'includes/asmplsww_admin_field.php';
    }

    // Asm Shipping Method Loading
    if (!class_exists('ASMPLSWW_Shipping_Method')) {
        include_once 'includes/asmplsww_shipping_method.php';
    }

    add_action('woocommerce_shipping_init', 'asmplsww_shipping_method_init');

    function asmplsww_shipping_method_add($methods)
    {
        $methods['asmplsww'] = 'ASMPLSWW_Shipping_Method';
        return $methods;
    }

    add_filter('woocommerce_shipping_methods', 'asmplsww_shipping_method_add');
}