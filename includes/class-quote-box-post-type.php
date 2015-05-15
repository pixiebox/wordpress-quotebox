<?php
class Quote_Box_Post_Type {
	function create_quote() {
		register_post_type( 'quotes',
			array(
				'labels' => array(
					'name' => __('Quotes', 'QuoteBox'),
					'singular_name' => __('Quote', 'QuoteBox'),
					'add_new' => __('Add New', 'QuoteBox'),
					'add_new_item' => __('Add New Quote', 'QuoteBox'),
					'edit' => __('Edit', 'QuoteBox'),
					'edit_item' => __('Edit Quote', 'QuoteBox'),
					'new_item' => __('New Quote', 'QuoteBox'),
					'view' => __('View', 'QuoteBox'),
					'view_item' => __('View Quote', 'QuoteBox'),
					'not_found' => __('Geen quotes gevonden', 'QuoteBox'),
					'not_found_in_trash' => __('Geen quotes gevonden in de Prullenbak', 'QuoteBox'),
				),
				'rewrite' => false,
				'public' => true,
				'show_ui' => true,
				'exclude_from_search' => true,
				'hierarchical' => true,
				'query_var' => true,
				'menu_position' => 15,
				'supports' => array( 'title', 'editor', 'thumbnail' ),
				'menu_icon' => plugins_url( 'images/quote.png', __FILE__ ),
				'has_archive' => false,
			)
		);
	}
}
?>