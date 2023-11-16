<?php

/**
 * 
 * NOTE:
 * 
 * This Snippet is using a custom field for each product by the name "min_stock", at the time i made this snippet,
 * i was using Advanced Custom Fields (ACF) plugin found here: https://wordpress.org/plugins/advanced-custom-fields/
 * 
 * You may use the same plugin to create this field or other way.
 * 
 */

/**
 * Change how the "step" works
 */
add_filter('woocommerce_quantity_input_step', 'nsk_allow_decimal', 10, 2);
function nsk_allow_decimal($int, $product) {

	$step = get_post_meta($product->get_id(), 'cutie_mp', true);
	$int = round($step, 3);

	return $int;
}

/**
 * Change from int values to float values
 */
remove_filter('woocommerce_stock_amount', 'intval');
add_filter('woocommerce_stock_amount', 'floatval');

/**
 * Apply the change globally
 */
add_filter( 'woocommerce_quantity_input_args', 'custom_quantity_input_args', 20, 2 );
function custom_quantity_input_args( $args, $product ) {

	$min_stock = get_post_meta($product->get_id(), 'min_stock', true);

    $args['min_value'] = round($min_stock, 3);
    $args['step'] = round($min_stock, 3);

    return $args;
}