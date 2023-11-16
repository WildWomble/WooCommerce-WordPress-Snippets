<?php

function add_order_profit_column_header( $columns ) {

    $new_columns = array();

    foreach ( $columns as $column_name => $column_info ) {
        $new_columns[ $column_name ] = $column_info;
        if ( 'order_total' === $column_name ) {
            $new_columns['payment_type'] = __( 'Payment Type', 'woocommerce' );
        }
    }
    return $new_columns;

}
add_filter( 'manage_edit-shop_order_columns', 'add_order_profit_column_header', 20 );

function add_order_profit_column_content( $column ) {

    global $post;

    if ( 'payment_type' === $column ) {
        $order = wc_get_order( $post->ID );
        $payment_method = $order->get_payment_method();

        echo $payment_method;
    }

}
add_action( 'manage_shop_order_posts_custom_column', 'add_order_profit_column_content' );