<?php

function is_shop_open() {
    date_default_timezone_set('Europe/Bucharest');

    $start_time   = mktime('10', '00', '00', date('m'), date('d'), date('Y')); // 10h
    $end_time     = mktime('21', '45', '00', date('m'), date('d'), date('Y')); // 17h
    $now_time     = time();
    $allowed_days = in_array( date('N'), array(1, 2, 3, 4, 5, 6, 7) ); // allowed from Monday - Sunday (each number is the number of the day)

    return $allowed_days && $now_time >= $start_time && $now_time <= $end_time ? true : false;
}

add_filter( 'woocommerce_variation_is_purchasable', 'shop_closed_disable_purchases' );
add_filter( 'woocommerce_is_purchasable', 'shop_closed_disable_purchases' );
function shop_closed_disable_purchases( $purchasable ) {
    return is_shop_open() ? $purchasable : false;
}

add_action( 'woocommerce_check_cart_items', 'shop_open_allow_checkout' );
add_action( 'woocommerce_checkout_process', 'shop_open_allow_checkout' );
function shop_open_allow_checkout() {
    if ( ! is_shop_open() ) {
        wc_add_notice( __("Comenzile online se pot plasa intre orele 10:00 si 21:45. Iti multumim!"), 'error' );
    }
}

add_action( 'template_redirect', 'shop_is_closed_notice' );
function shop_is_closed_notice(){
    if ( ! ( is_cart() || is_checkout() ) && ! is_shop_open() ) {
        wc_add_notice( sprintf( '<span class="shop-closed">%s</span>',
            esc_html__('Comenzile online se pot plasa intre orele 10:00 si 21:45. Iti multumim!', 'woocommerce' )
        ), 'notice' );
    }
}
