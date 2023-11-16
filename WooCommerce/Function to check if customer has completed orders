<?php

function has_bought() {
	$customer_orders = get_posts(
		array( 
			'numberposts'	=> -1, 
			'meta_key'		=> '_customer_user',
			'meta_value'	=> get_current_user_id(),
			'post_type'		=> 'shop_order',
			'post_status'	=> 'wc-completed' )
		);
		
  return count($customer_orders) > 0 ? true : false; 
}
