<?php 

// Enable endpoint
add_filter( 'woocommerce_get_query_vars', 'myaccount_custom_endpoint_query_var' );
function myaccount_custom_endpoint_query_var( $query_vars ) {

    //create the new page in My Account
    $query_vars['formular-retur'] = 'formular-retur';

    return $query_vars;
}

// Endpoint displayed content
add_action('woocommerce_account_formular-retur_endpoint', 'display_custom_endpoint_content' ); 
function display_custom_endpoint_content(){

    //You can use any kind of form or create one yourself here,

    echo do_shortcode('[contact-form-7 id="54195" title="Retur"]');
}
// Add it as my account menu item
add_filter ( 'woocommerce_account_menu_items', 'custom_account_menu_items', 10 );
function custom_account_menu_items( $menu_links ){
    $menu_links = array_slice( $menu_links, 0,3 , true )
    + array( 'formular-retur' => __('Formular Retur') )
    + array_slice( $menu_links, 3, NULL, true );

    return $menu_links;
}

// Endpoint page title
add_filter( 'woocommerce_endpoint_custom-endpoint_title', 'set_my_account_custom_endpoint_title', 10, 2 );
function set_my_account_custom_endpoint_title( $title, $endpoint ) {
    $title = __( "Formular Retur", "woocommerce" );

    return $title;
}