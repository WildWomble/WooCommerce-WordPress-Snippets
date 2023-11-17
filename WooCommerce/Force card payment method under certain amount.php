<?php

add_filter( 'woocommerce_available_payment_gateways', 'hide_payment_gateways_based_on_total', 11, 1 );
function hide_payment_gateways_based_on_total( $available_gateways ) {
    //if ( is_admin() ) return $available_gateways; // Only on frontend

    if( WC()->cart->subtotal <= 100.00 && isset($available_gateways['cod']) ) {
        unset($available_gateways['cod']); // unset 'cod'
	}

    return $available_gateways;
}
add_action('template_redirect', 'my_custom_message');
function my_custom_message() {
    if ( WC()->cart->subtotal <= 100.00 && is_checkout() ) {
		wc_add_notice( __('<div id="notice-below">Pentru comenzile sub 100 RON se acceptă doar plata cu cardul.</div>'), 'notice' );
    }
}