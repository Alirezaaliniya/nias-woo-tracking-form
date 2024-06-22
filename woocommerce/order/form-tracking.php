<?php
/**
 * Order tracking form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/form-tracking.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $post;
?>

<form action="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" method="post" class="woocommerce-form woocommerce-form-track-order track_order">

	<?php
	/**
	 * Action hook fired at the beginning of the form-tracking form.
	 *
	 * @since 6.5.0
	 */
	do_action( 'woocommerce_order_tracking_form_start' );
	?>

	<p>برای پیگیری سفارش، لطفا شماره سفارشی که برای شما پیامک شده را در کادرهای زیر وارد کرده و دکمه پیگیری را فشار دهید. شماره سفارش از طریق پنل کاربری و پیامکی که به شما ارسال شده در اختیارتان قرار گرفته است</p>

	<p class="form-row form-row-first"><label for="orderid"><?php esc_html_e( 'Order ID', 'woocommerce' ); ?></label> <input class="input-text" type="text" name="orderid" id="orderid" value="<?php echo isset( $_REQUEST['orderid'] ) ? esc_attr( wp_unslash( $_REQUEST['orderid'] ) ) : ''; ?>" placeholder="شماره سفارش در پیامک ارسال شده به شما موجود است" /></p><?php // @codingStandardsIgnoreLine ?>

	<div class="clear"></div>

	<?php
	/**
	 * Action hook fired in the middle of the form-tracking form (before the submit button).
	 *
	 * @since 6.5.0
	 */
	do_action( 'woocommerce_order_tracking_form' );
	?>

	<p class="form-row"><button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="track" value="<?php esc_attr_e( 'Track', 'woocommerce' ); ?>"><?php esc_html_e( 'Track', 'woocommerce' ); ?></button></p>
	<?php wp_nonce_field( 'woocommerce-order_tracking', 'woocommerce-order-tracking-nonce' ); ?>

	<?php
	/**
	 * Action hook fired at the end of the form-tracking form (after the submit button).
	 *
	 * @since 6.5.0
	 */
	do_action( 'woocommerce_order_tracking_form_end' );
	?>

</form>
