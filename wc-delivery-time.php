<?php
namespace Hackeamos\WooCommerce\DeliveryTime;
const WP_DEBUG=true;
/**
 * Delivery Time for Woocommerce
 *
 * @package           wc-delivery-time
 * @author            Lucilio Correia
 * @copyright         2019 Lucilio.net
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Delivery Time for Woocommerce
 * Plugin URI:        https://lucilio.net/projects/wc-delivery-time
 * Description:       Shows delivery time for WooCommerce products.
 * Version:           0.1.0
 * Requires at least: 5.8.3
 * Requires PHP:      7.4
 * Author:            Lucilio Correia
 * Author URI:        https://lucilio.net
 * Text Domain:       wc-delivery-time
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://lucilio.net/projects/wc-delivery-time/updates
 * 
 * WC requires at least: 6.1
 * WC tested up to: 6.1
 *  
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is activated
 * @see https://woocommerce.com/document/query-whether-woocommerce-is-activated/
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        return class_exists( 'woocommerce' );
    }
}

const POST_META_KEY='delivery-time-in-days';

/**
 * Load plugin scripts if Woocommerce plugin is found and activated
 */
function plugin_init() {

    /**
     * bounce if no woocommerce plugin is found active
     */
    if( ! is_woocommerce_activated() ) {
        return true;
    }
    
    /**
     * load textdomain
     */
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    $plugin_data = get_plugin_data( __FILE__ );
    load_plugin_textdomain( $plugin_data['TextDomain'], false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

    /**
     * load plugin scripts
     */
    require_once plugin_dir_path( __FILE__ ) . "/settings.php";
    require_once plugin_dir_path( __FILE__ ) . "/post-meta.php";
    require_once plugin_dir_path( __FILE__ ) . "/display.php";
}
add_action( 'woocommerce_init', __NAMESPACE__ . "\plugin_init", 10 );

?>

