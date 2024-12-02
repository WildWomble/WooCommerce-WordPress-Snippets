<?php
/*
The way it works is:

You have an offer for a set of 4 products withing the Pizza category, the cost of each product only matters in the final sum to give the discount

A set has a fixed price, this one is set to 69.

In cart it will take 4 products, sum their total cost and substract 69 (see line 81), the given result will be discounted from the final price.

Product #1 - 12$
Product #2 - 15$
Product #3 - 13$
Product #4 - 10$

Set = 30$

Sum of all products = 50$
Discount applied = 50 - 30 = 20$

*/
add_action('woocommerce_cart_calculate_fees', 'apply_flat_discount_for_sets_of_4_in_category', 20);
function apply_flat_discount_for_sets_of_4_in_category($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;

    // Set the category slug where the discount should apply
    $category_slug = 'pizza';  // Slug of category

    // Variables to track the number of products in the specified category
    $category_product_count = 0;
    $total_category_cost = 0;
    $total_discount = 0;
    $eligible_products = [];

  
    // Loop through cart items and gather only those in the specified category
    foreach ($cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];

        // Check if the product belongs to the specified category
        if (has_term($category_slug, 'product_cat', $product->get_id())) {
            $product_price = floatval($product->get_price());

          /*
          Here i am using a plugin Advanced Product Fields (Product Addons) for WooCommerce (https://wordpress.org/plugins/advanced-product-fields-for-woocommerce/)
          to add toppings for my products.
          This code excludes the toppings to be taken in consideration for the final discounts
          */
            // Deduct topping prices if 'wapf' data is present
            if (!empty($cart_item['wapf'])) {
                foreach ($cart_item['wapf'] as $wapf_item) {
                    if (!empty($wapf_item['price'])) {
                        foreach ($wapf_item['price'] as $price_item) {
                            $product_price -= floatval($price_item['value']);
                        }
                    }
                }
            }

            // Accumulate product count and base cost (excluding toppings) for the specified category
            $category_product_count += $cart_item['quantity'];
            $total_category_cost += $product_price * $cart_item['quantity'];

            // Store each product's base price for calculation
            for ($i = 0; $i < $cart_item['quantity']; $i++) {
                $eligible_products[] = $product_price;
            }
        }
    }

    // Calculate discount for complete sets of 4 products
    $sets_of_4 = floor($category_product_count / 4);

    if ($sets_of_4 > 0) {
        // Calculate the total desired cost for the sets of 4 products
        $desired_total_cost = $sets_of_4 * 69;

        // Calculate the total discount to apply
        for ($i = 0; $i < $sets_of_4 * 4; $i += 4) {
            $set_cost = array_sum(array_slice($eligible_products, $i, 4));
            $total_discount += $set_cost - 69; // Each set should cost exactly 69 lei
        }

        // Apply the discount if there is any
        if ($total_discount > 0) {
            $cart->add_fee(__('Offer'), -$total_discount);
        }
    }
}
