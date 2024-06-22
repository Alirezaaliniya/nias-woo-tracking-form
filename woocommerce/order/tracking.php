<?php
/**
 * Order tracking
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/tracking.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.2.0
 */

defined( 'ABSPATH' ) || exit;

// Debug check
if ( ! isset( $order ) || ! $order ) {
    echo '<p>' . esc_html__( 'Order not found.', 'nias-woo-tracking-form' ) . '</p>';
    return;
}

$notes = $order->get_customer_order_notes();
?>
<p class="view_order_status">
    <span class="order-number"><i class="fal fa-hashtag"></i><b> شناسه : </b><?php echo esc_html( $order->get_order_number() ); ?></span>
    <span class="order-date"><i class="fal fa-calendar-day"></i><b> تاریخ ثبت : </b><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
    <span class="order-status"><i class="fal fa-tasks-alt"></i><b> وضعیت : </b><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></span>
</p>

<?php if ( $notes ) : ?>
    <h2><?php esc_html_e( 'Order updates', 'woocommerce' ); ?></h2>
    <ol class="commentlist notes">
        <?php foreach ( $notes as $note ) : ?>
            <li class="comment note">
                <div class="comment_container">
                    <div class="comment-text">
                        <p class="meta"><?php echo esc_html( date_i18n( __( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ) ); ?></p>
                        <div class="description">
                            <?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order->get_id() ); ?>
