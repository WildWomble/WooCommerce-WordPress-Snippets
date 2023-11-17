<?php

add_action( 'woocommerce_cart_calculate_fees', 'applyDiscountToOrder', 20, 1 );
function applyDiscountToOrder( $cart ) {
	
	$subtotal = WC()->cart->get_subtotal();

    foreach( WC()->cart->get_cart() as $key => $item ) {

        $product = $item['data'];

        if($product->is_on_sale() == true) {
            $item_subtotal = $product->get_sale_price() * $item['quantity'];
            $subtotal = $subtotal - $item_subtotal;
        }

    }

	$procentaj = addDicountFromOrders($subtotal);
	
	$discount = $subtotal * $procentaj / 100;
	
	if($discount != 0) {
		$cart->add_fee( sprintf( __( 'Discount %s', 'woocommerce'), $procentaj .'%' ), -$discount );

        //notice to let the customer know it doesnt apply for products that are already on sale
        wc_add_notice('Reducerea se aplică doar produselor care nu au ofertă existentă.');
    }
}
function addDicountFromOrders($subtotal) {
	
	$discountPer = $subtotal / 100;
	
	if($discountPer > 25) {
		$discountPer = 25;
	}
	
	return floor($discountPer);
}