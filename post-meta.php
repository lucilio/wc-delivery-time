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

use Hackeamos\WooCommerce\DeliveryTime\POST_META_KEY;

/**
 * Shows delivery time post metabox
 */
function add_product_data_fields() {
    ?>
</div>
<div class="options_group">
    <?php
    $delivery_time = get_post_meta( get_the_ID(), POST_META_KEY, true );
    if( empty( $delivery_time ) ) {
        $delivery_time = 0;
    }
    $field = array(
        'id' => POST_META_KEY,
        'label' => __('Delivery Time', 'wc-delivery-time'),
        'type' => 'number',
        'custom_attributes' => array(
            'min' => -1,
            'pattern' => '(\d+) dias'
        ),
        'description' => __('Delivery time for this product in days. Default value will be displayed if value is set to 0. Set to -1 for hiding delivery time info.', 'wc-delivery-time'),
        'desc_tip' => true,
        'value' => $delivery_time
    );
    woocommerce_wp_text_input( $field );
    ?>
</div>
    <?php
}
add_filter( 'woocommerce_product_options_shipping', __NAMESPACE__ . '\add_product_data_fields', 10, 1 );

/**
 * Save delivery time meta data
 */
function save_product_data( $post_id, $post ) {
    $meta_key=POST_META_KEY; // not necessary
    $delivery_time = isset( $_POST[ POST_META_KEY ] ) ? $_POST[ POST_META_KEY ] : null;
    if( is_null( $delivery_time )  ) {
        return false;
    }
    if( ! is_numeric( $delivery_time ) ) {
        return false;
    }
    update_post_meta( $post_id, $meta_key, $delivery_time );
}
add_action( 'woocommerce_process_product_meta', __NAMESPACE__ . '\save_product_data', 10, 2 );
?>