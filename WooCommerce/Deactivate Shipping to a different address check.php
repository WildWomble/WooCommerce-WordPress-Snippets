<?php
// Yes, one line, could be an option in WooCommerce but nooo

add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );