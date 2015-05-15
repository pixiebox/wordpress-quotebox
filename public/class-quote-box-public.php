<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://pixiebox.com
 * @since      0.1
 *
 * @package    Quote_Box
 * @subpackage Quote_Box/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the quote box, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Quote_Box
 * @subpackage Quote_Box/public
 * @author     Your Name <email@example.com>
 */
class Quote_Box_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $quote_box    The ID of this plugin.
	 */
	private $quote_box;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1
	 * @param      string    $quote_box       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $quote_box, $version ) {

		$this->quote_box = $quote_box;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quote_Box_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quote_Box_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->quote_box, plugin_dir_url( __FILE__ ) . 'css/quote-box-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quote_Box_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quote_Box_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->quote_box, plugin_dir_url( __FILE__ ) . 'js/quote-box-public.js', array( 'jquery' ), $this->version, false );

	}

	/*function register_my_script() {
		wp_register_script('my-script', plugins_url('js/srcBox.js', __FILE__), array(), '1.0', true);
	}*/

	/*function print_my_script() {
		global $add_my_script;

		if ( ! $add_my_script )
			return;

		wp_print_scripts('my-script');
	}*/

	function quote_box_shortcode_handler($atts = array(), $content = "") {
		//global $add_my_script;

		//$add_my_script = true;

		// actual shortcode handling here
		$html = '';
		$args = array(
			'post_type' => 'quotes',
			'post_status' => 'publish'
		);
		if (isset($atts['id']) && $atts['id'] !== 'all') :
			$args['p'] = (int) $atts['id'];
		endif;

		$my_query = null;
		$my_query = new WP_Query($args);
		
		if ($my_query->post_count > 0) :
			$html .= '<div class="quote-box">';

			if (!isset($atts['id']) || $atts['id'] !== 'all') :
				$rand = rand(0, ($my_query->post_count - 1));
				$mypost = $my_query->posts[$rand];
				$featured_image = get_the_post_thumbnail( $mypost->ID, 'thumbnail');

				$html .= '	<blockquote>' . $mypost->post_content . '</blockquote>';

				if (!empty($featured_image)) :
					$html .= '	<strong class="head has-featured-image">' . $mypost->quotebox_employee . ' <span>' . $mypost->quotebox_jobtitle . '</span></strong>';
					$html .= '	<div class="ph-image">';
					$html .=  		$featured_image;
					$html .= '	</div>';
				else :
					$html .= '	<strong class="head">' . $mypost->quotebox_employee . ' <span>' . $mypost->quotebox_jobtitle . '</span></strong>';
				endif;

				$html .= 	'<div class="clear"></div>';
			else :
				foreach ($my_query->posts as $quote) :
					$html .= '	<blockquote>' . $quote->post_content . '</blockquote>';

					$featured_image = get_the_post_thumbnail( $quote->ID, 'thumbnail');

					if (!empty($featured_image)) :
						$html .= '	<strong class="head has-featured-image">' . $quote->quotebox_employee . ' <span>' . $quote->quotebox_jobtitle . '</span></strong>';
						$html .= '	<div class="ph-image">';
						$html .=  		$featured_image;
						$html .= '	</div>';
					else :
						$html .= '	<strong class="head">' . $quote->quotebox_employee . ' <span>' . $quote->quotebox_jobtitle . '</span></strong>';
					endif;

					$html .= 	'<div class="clear"></div>';
				endforeach;
			endif;

			$html .= '</div>';
		endif; 
		wp_reset_query();
		//return '';
		return $html;
	}
}
