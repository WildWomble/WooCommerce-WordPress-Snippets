<?php

function modify_woocommerce_get_item_data( $item_data, $cart_item ) {
    $variations = $cart_item['variation'];

	// var_dump($cart_item);

	$output = null;

	$output = "<ul>";
    foreach ( $variations as $key => $value ) {
		$output .= "<li><span style='font-weight: bold'>{$key}</span>: <span>{$value}</span></li>";
    }

	$output .= "</ul>";

    
    echo $output;
}
add_filter( 'woocommerce_get_item_data', 'modify_woocommerce_get_item_data', 99, 2 );