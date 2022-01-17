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
 * Show delivery time info on frontend
 * @todo make $display_text dynamic when delicery time is -1
 * @todo allow changing display text template from admin panel
 */
function display_delivery_time() {
    
    # bounce if is archive page and no displaying on archive pages is on
    if( is_archive() ) {
        $display_on_archive = get_option( 'delivery_time_display_on_archive' );
        if( $display_on_archive !== 'yes' ) {
            return true;
        }
    }

    # same for single pages
    if( is_singular( 'product' ) ) {
        $display_on_single = get_option( 'delivery_time_dispay_on_single', 'no' );
        if( $display_on_single !== 'yes' ) {
            return true;
        }
    }

    # get delivery time and abort if it's -1
    $delivery_time = get_post_meta( get_the_ID(), POST_META_KEY, true );
    if( $delivery_time == 0 ) {
        $delivery_time = get_option( 'delivery_time_days' );
    }

    # set color and text to display
    $display_color = get_option( 'delivery_time_color', 'inherit' );

    $display_text = sprintf(
        /* translators: %d is replaced with the number of days */
        _n( 'Delivery time: %d day',
            'Delivery time: %d days',
            $delivery_time,
            'wc-delivery-time' ),
        $delivery_time // replacement sprintf
    );

    # replace display text if $delivery_time is set to -1
    if( $delivery_time == -1 ) {
        // adding &nbsp keeps vertical alignment in archive pages 
        $display_text='&nbsp;';
    }

    ?>
    <div class="delivery-time" style="color: <?php echo $display_color; ?>">
        <?php echo $display_text; ?>
    </div>
    <?php
}
add_action( 'woocommerce_after_add_to_cart_button', __NAMESPACE__ . '\display_delivery_time', 10 );
add_action( 'woocommerce_after_shop_loop_item', __NAMESPACE__ . '\display_delivery_time', 10 );
?>