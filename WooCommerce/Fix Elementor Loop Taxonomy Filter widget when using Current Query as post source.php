/* Elementor uses the endpoint refresh-loop when using the Taxonomy Filter widget
** By default it will not filter properly when you reset the filters and will cause it to show all the products
** IMPORTANT:
** Go to elementor-pro/modules/loop-filter/data/endpoints/refresh-loop.php
** Add the following in the get_updated_loop_widget_markup() function after the $data = $request->get-params() line:

if ( empty( $data['widget_filters']['taxonomy']['product_cat'] ) && ! empty( $data['pagination_base_url'] ) ) {

	$pagination_url = esc_url_raw( $data['pagination_base_url'] );
	$parsed_url     = parse_url( $pagination_url );
	
	if ( !empty( $parsed_url['path'] ) ) {
	
		// Explode the path into parts and get the last part as the category slug
		$path_parts     = array_filter( explode( '/', $parsed_url['path'] ) );
		$current_category = array_pop( $path_parts );
	
		if( $current_category && $current_category !== 'shop' ) {
			$data['widget_filters']['taxonomy']['product_cat'] = [ 'terms' => [ $current_category ] ];
		}
	}
}



/* also modifying in function "get_hierarchy_of_selected_terms()" (line 150 as of now) the return to be:

return 
	'single-term' => $single_selection_term,
	'parent-terms-without-children' => $parents_without_children,
	'hierarchical-terms' => $parents_with_children_by_parent,
	'logicalJoin' => "AND", // this line was changed to AND since i dont use OR
	'taxonomy' => $taxonomy,
];
