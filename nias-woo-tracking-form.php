<?php
/*
 * Plugin Name:       nias woo tracking form
 * Plugin URI:        https://Nias.ir
 * Description:       اصلاح فرم پیگیری سفارشات ووکامرس
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            علیرضا علی نیا
 * Author URI:        https://Nias.ir/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://Nias.ir/
 * Text Domain:       nias-woo-tracking-form
 */

defined('ABSPATH') || exit;

define('MAIN_NIAS_WOO', plugin_dir_path(__FILE__) . 'woocommerce/order');
define('NIAS_WOO_ASSET', plugin_dir_url(__FILE__) . 'assets');

// Enqueue custom styles
function nias_woo_style() {
    wp_enqueue_style('nias-woo-style', NIAS_WOO_ASSET . '/nias-woo-style.css');
}
add_action('wp_enqueue_scripts', 'nias_woo_style');

// Load custom templates
add_filter('woocommerce_locate_template', 'nias_woo_locate_template', 10, 3);
function nias_woo_locate_template($template, $template_name, $template_path) {
    global $woocommerce;

    $_template = $template;
    if (!$template_path) $template_path = $woocommerce->template_url;

    $plugin_path = untrailingslashit(plugin_dir_path(__FILE__)) . '/woocommerce/';

    // Look within passed path within the theme - this is priority
    $template = locate_template(
        array(
            $template_path . $template_name,
            $template_name
        )
    );

    // Modification: Get the template from this plugin, if it exists
    if (!$template && file_exists($plugin_path . $template_name)) {
        $template = $plugin_path . $template_name;
    }

    // Use default template
    if (!$template) {
        $template = $_template;
    }

    // Return what we found
    return $template;
}

// Shortcode for custom order tracking
function nias_woocommerce_shortcode_track_order() {
    if (isset($_POST['track'])) {
        $order_id = isset($_POST['orderid']) ? wc_clean($_POST['orderid']) : '';

        if (!$order_id) {
            wc_add_notice(__('لطفاً شماره سفارش را وارد کنید', 'nias-woo-tracking-form'), 'error');
        } else {
            $order = wc_get_order($order_id);

            if ($order) {
                // Display order details or do whatever you need with the order
                wc_get_template(
                    'order/tracking.php',
                    array(
                        'order' => $order,
                    ),
                    '', // Leave the template path empty to use default WooCommerce template path.
                    MAIN_NIAS_WOO . '/' // Path to your custom templates in the plugin.
                );
            } else {
                wc_add_notice(__('Order not found.', 'nias-woo-tracking-form'), 'error');
            }
        }
    }

    wc_get_template(
        'order/form-tracking.php',
        array(),
        '',
        MAIN_NIAS_WOO . '/'
    );
}

// Remove default shortcode and add custom one
remove_shortcode('woocommerce_order_tracking');
add_shortcode('nias_woocommerce_order_tracking', 'nias_woocommerce_shortcode_track_order');
