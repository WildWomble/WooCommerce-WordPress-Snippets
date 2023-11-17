<?php

// Add a custom fee based o cart subtotal
add_action( 'woocommerce_cart_calculate_fees', 'custom_fee_for_tinkoff', 20, 1 );
function custom_fee_for_tinkoff ( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    if ( ! ( is_checkout() && ! is_wc_endpoint_url() ) )
        return; // Only checkout page

    $payment_method = WC()->session->get( 'chosen_payment_method' );

    if ( 'cod' == $payment_method ) {

        //the fee amount
        $surcharge = 5;

        //the fee's name
        $cart->add_fee( 'Procesare plata', $surcharge, true );
    }
}

// jQuery - Update checkout on methode payment change  
add_action( 'wp_footer', 'custom_checkout_jqscript' );
function custom_checkout_jqscript() {
    if ( ! ( is_checkout() && ! is_wc_endpoint_url() ) )
        return; // Only checkout page
    ?>
    <script type="text/javascript">
    jQuery( function($){
        $('form.checkout').on('change', 'input[name="payment_method"]', function(){
            $(document.body).trigger('update_checkout');
        });
    });
    </script>
    <?php
}