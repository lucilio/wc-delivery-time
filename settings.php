<?php
namespace Hackeamos\WooCommerce\DeliveryTime;
/**
 * Delivery Time for Woocommerce
 *
 * @package           wc-delivery-time
 * @author            Lucilio Correia
 * @copyright         2019 Lucilio.net
 * @license           GPL-2.0-or-later
 *
 */

// bounce if WordPress was not loaded
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Adds a dedicated tab into Woocommerce -> Settings -> Products
 * @param array $section Sections array provided by woocommerce_get_sections_products hook
 */
function add_settings_tab( $sections ) {
    $sections['delivery-time'] = __('Delivery Time', 'wc-delivery-time');
    return $sections;
}
add_filter( 'woocommerce_get_sections_products', __NAMESPACE__ . '\add_settings_tab', 10 );

/**
 * Adds fields to Woocommerce -> Settings -> Products -> Delivery Time
 * @param array $section Sections array provided by woocommerce_get_sections_products hook
 */
function add_settings_tab_fields( $sections, $current_section ) {
    if( $current_section == 'delivery-time' ) {
        $settings = array();
        $settings[] = array(
            'id' => 'delivery-time',
            'name' => __('Delivery Time', 'wc-delivery-time'),
            'type' => 'title',
            'desc' => __('Shows delivering time on woocommerce products', 'wc-delivery-time')
        );
        $settings[] = array(
            'id' => 'delivery_time_days',
            'name' => __('Delivery time', 'wc-delivery-time'),
            'type' => 'number',
            'default' => -1,
            'desc' => __('Default delivery time for products', 'wc-delivery-time')
        );
        $settings[] = array(
            'id' => 'delivery_time_display_on_archive',
            'name' => __('Display on', 'wc-delivery-time'),
            'type' => 'checkbox',
            'desc' => __('Product archive page', 'wc-delivery-time'),
            'default' => 'yes'
        );
        $settings[] = array(
            'id' => 'delivery_time_dispay_on_single',
            'type' => 'checkbox',
            'desc' => __( 'Single product page', 'wc-delivery-time'),
            'default' => 'no'
        );
        $settings[] = array(
            'id' => 'delivery-time-color',
            'name' => __('Color', 'wc-delivery-time'),
            'type' => 'color',
            'default' => 'inherit',
            'desc' => __('Color to delivery time display font', 'wc-delivery-time')
        );
        return $settings;
    }
    else {
        return $sections;
    }
}
add_filter( 'woocommerce_get_settings_products', __NAMESPACE__ . '\add_settings_tab_fields', 10, 2 );