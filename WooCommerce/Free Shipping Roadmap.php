<?php

add_filter('woocommerce_after_cart_totals', 'HTMLRoadmap', 10);
add_filter('woocommerce_review_order_after_submit', 'HTMLRoadmap', 10);
function HTMLRoadmap() {
	global $woocommerce;

	$output = '';
	$max = 300;
	$subtotal = $woocommerce->cart->subtotal;;
	
	$necesar = $max - $subtotal;
	$output .= '<div id="roadmapToFreeShipping">';

	if($necesar < 0) { 

		//translation: Your order benefits from free shipping!
		$output .= '<div class="title"><strong>Comanda ta beneficiază de transport gratuit!<strong></div>';
	} else {

		//translation: You still need % lei to benefit of free shipping!
		$output .= '<div class="title">Comandă de încă <span>'.$necesar.' lei</span> pentru a beneficia de transport gratuit!</div>';
	}
	$output .= '</div>';
	
	echo $output;
}

/**
 * CSS:
 * 
 * #roadmapToFreeShipping { padding: 10px; background: #009900cf; color: #fff; text-align: center; margin-bottom: 15px; } 
 * #roadmapToFreeShipping span { font-weight: bold; text-decoration: underline }
 */