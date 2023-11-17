<?php
/**
 * Example: https://domain.com/?redirect_sku=12345 will redirect directly to the product that matches the SKU
 */

// Register endpoint
add_action( 'init', function() {
    add_rewrite_endpoint( 'redirect_sku', EP_ROOT );
} );

add_action( 'template_redirect', function() {
    global $wp_query;

    $sku = $wp_query->get('redirect_sku');

    // Bail early
    if ( ! $sku ) {
        return;
    }

    // Get product id by SKU
    $productId = wc_get_product_id_by_sku( $sku );

    // No product found
    if ( ! $productId ) {
        $wp_query->set_404();
        status_header(404);
        return;
    }

    // Redirect to product
    wp_redirect( get_permalink( $productId ) );
    exit;
} );