<?php
/*
Quote Box: Quote Widget
Plugin URI: http://pixiebox.com
Description: Quote Widget grabs a random or assigned quote post and the associated thumbnail to display on your sidebar
Author: Patrick Danhof
Version: 0.1
Author URI: http://pixiebox.com
*/

class QuoteBoxWidget extends WP_Widget {

	function QuoteBoxWidget () {

		$widget_ops = array( 'classname' => 'QuoteBoxWidget', 'description' => __( 'Displays a random or assigned quote post with thumbnail', 'QuoteBox' ) );
		$this->WP_Widget( 'QuoteBoxWidget', 'Quote Post and Thumbnail', $widget_ops );

	}
 
	function form ( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php _e( 'Title', 'QuoteBox' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
			</label>
		</p>
<?php

	}
 
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		return $instance;

	}
 
	function widget($args, $instance) {

		extract($args, EXTR_SKIP);
	 
		echo $before_widget;

		$title = empty($instance['title'])
			? ' '
			: apply_filters('widget_title', $instance['title']);
	 
		if (!empty($title))
			echo $before_title . $title . $after_title;;

		// WIDGET CODE GOES HERE
		$page_id = get_query_var('page_id');
		if ($page_id == 0) $page_id = url_to_postid(get_post_permalink());

		$categories = get_the_category();
		$category_id = $categories[0]->cat_ID;

		$post_id = get_query_var('p');

		$args = array(
			'compare' 		=> 'LIKE',
			'post_status'	=> 'publish',
			'post_type' 	=> 'quotes',
		);

		if (!empty($category_id)) :

			$args['meta_key'] = 'quotebox_page_id';
			$args['meta_value'] = $category_id;

		elseif (!empty($page_id)) :

			$args['meta_key'] = 'quotebox_page_id';
			$args['meta_value'] = $page_id;

		elseif (!empty($post_id)) :

			$category_id = wp_get_post_categories($post_id);
			$args['meta_key'] = 'quotebox_page_id';
			$args['meta_value'] = $category_id[0];

		endif;

		$wpquery = new WP_Query($args);

		if ( $wpquery->post_count > 0 ) :

			if ( empty($page_id) && empty($post_id) ) {
				$rand = rand( 0, ( $wpquery->post_count - 1 ) );
				$post = $wpquery->posts[$rand];
			} else {
				$post = $wpquery->posts[0];
			}

			$featured_image = get_the_post_thumbnail( $post->ID, 'thumbnail');

			echo '
			<div class="quote-box">
				<blockquote>' . $post->post_content . '</blockquote>

				<strong class="head">' . $post->quotebox_employee . ' <span>' . $post->quotebox_jobtitle . '</span></strong>

				<div class="ph-image">'
			.		$featured_image . '
				</div>
				<div class="clear"></div>
			</div>';

		endif;

		wp_reset_query();

		echo $after_widget;

	}

}
?>