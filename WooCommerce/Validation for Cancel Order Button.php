<?php

add_filter( 'woocommerce_valid_order_statuses_for_cancel', 'custom_valid_order_statuses_for_cancel', 10, 2 );

function custom_valid_order_statuses_for_cancel( $statuses, $order ) {

    // Set HERE the order statuses where you want the cancel button to appear
    $custom_statuses = array( 'pending', 'processing', 'on-hold' );

    // Set HERE the delay (in days)
    $duration = 5;

    // UPDATE: Get the order ID and the WC_Order object
    if( isset($_GET['order_id']))
        $order = wc_get_order( absint( $_GET['order_id'] ) );

    $delay = $duration*24*60*60; // (duration in seconds)
    $date_created_time  = strtotime($order->get_date_created()); // Creation date time stamp
    $date_modified_time = strtotime($order->get_date_modified()); // Modified date time stamp
    $now = strtotime("now"); // Now  time stamp

    // Using Creation date time stamp
    if ( ( $date_created_time + $delay ) >= $now ) return $custom_statuses;
    else return $statuses;
}