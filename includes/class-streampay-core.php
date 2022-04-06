<?php

/**
 * Fired the streampay Payments Gateways Core.
 *
 * @link       https://plugins.streampay.shop
 * @since      1.0.0
 *
 * @package    StreamPay
 * @subpackage StreamPay/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Fired the StreamPay Payments Gateways Core.
 *
 * This class defines all code necessary to run to load the Payment Gateways.
 *
 * @since      1.0.0
 * @package    StreamPay
 * @subpackage StreamPay/includes
 * @author     StreamPay  <streampayment@protonmail.com>
 */
class streampay_Core {

	/**
	 * Fries the core functionlity for StreamPay/Recieve an error message in streampay log if the main class from WooCommerce doesn't exist and include the main functionality if everything is fine.
	 *
	 * @return void
	 */
	public function woocommerce_streampay_init() {
		if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
			return;
		} else {
			if ( is_readable( streampay_ROOT . 'includes/class-wc-streampay-solana.php' ) ) {
				require_once streampay_ROOT . 'includes/class-wc-streampay-solana.php';
			}
		}
	}
	/**
	 * Add StreamPay method to the woocommerce payments gateway.
	 *
	 * @param array $methods an array of wooCommerce methods that already exists.
	 * @return array $methods the same array but with StreamPay added to it as a payment method.
	 */
	public function woocommerce_streampay_gateway( $methods ) {
		$methods[] = 'WC_streampay_Solana';
		return $methods;
	}
	/**
	 * Add new settings links for StreamPay Plugin banner.
	 *
	 * @param array $links an array of existing links.
	 * @return array $links an array of the new added links to the old $links.
	 */
	public function streampay_settings_link( $links ) {
		// Build and escape the URL.
		$url = esc_url( get_admin_url() . 'admin.php?page=wc-settings&tab=checkout&section=' . streampay_GATEWAY_ID );
		// Create the link.
		$settings_link = "<a href='$url'>" . esc_html__( 'Settings', 'streampay' ) . '</a>';
		// Adds the link to the end of the array.
		array_push(
			$links,
			$settings_link
		);
		return $links;
	}
	/**
	 * Add StreamPay Voucher.
	 *
	 * @param integer $order_id is the order recieved.
	 * @return void
	 */
	public function add_streampay_special_voucher( $order_id ) {
		if ( ! class_exists( 'WC_Order' ) ) {
			return;
		}
		$order           = new WC_Order( $order_id );
		$memo_session    = get_post_meta( $order_id, 'streampay_memo', true );
		$order_signature = get_post_meta( $order_id, 'streampay_signature', true );
		$cluster         = get_post_meta( $order_id, 'streampay_cluster', true );
		$solscan         = "https://solscan.io/tx/$order_signature?cluster=$cluster";
		?>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order memo:', 'streampay' ); ?>
					<strong><?php echo esc_html( $memo_session ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Transaction:', 'streampay' ); ?>
					<strong><a href="<?php echo esc_url( $solscan ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank"><?php esc_html_e( 'Click here for details', 'streampay' ); ?></a></strong>
				</li>

			</ul>
		<?php
	}
}

