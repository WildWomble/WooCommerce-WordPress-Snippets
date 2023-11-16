<?php

/**
 * This snippet uses the function found in "Check if customer has completed orders"
 */

add_action('woocommerce_before_cart', 'first_order');

function first_order() {

	global $woocommerce;

    // change these to your existing coupon
	$coupon_name = 'first_order';
	$coupon_id = 8690;

	if(has_bought() == false) {

    	if ( $woocommerce->cart->has_discount( 'first_order' ) ) return;
    	$woocommerce->cart->apply_coupon( $coupon_name );

        // Message when the coupon is applied
		if(in_array($coupon_id, $woocommerce->cart->get_applied_coupons())){
    		echo '<div class="woocommerce-message"><strong>Congratulations! You have received a 5% discount for your first order.</strong></div>';
    	}
	} else {
		if ( $woocommerce->cart->get_applied_coupons( $coupon_name ) ) { $woocommerce->cart->remove_coupon( $coupon_name ); }
	}

}