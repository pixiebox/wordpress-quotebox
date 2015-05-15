<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://pixiebox.com
 * @since      0.1
 *
 * @package    Quote_Box
 * @subpackage Quote_Box/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the quote box, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Quote_Box
 * @subpackage Quote_Box/admin
 * @author     Patrick Danhof <info@pixiebox.com>
 */
class Quote_Box_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $quote_box    The ID of this plugin.
	 */
	private $quote_box;
	private $plugin_slug = 'quote_box';

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
	 * @param      string    $quote_box       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $quote_box, $version ) {

		$this->quote_box = $quote_box;
		$this->version = $version;

		add_action( 'init',  array( $this, 'quote_box_register_post_types') );
		add_action( 'widgets_init', create_function('', 'return register_widget("QuoteBoxWidget");') );
		
		add_action( 'add_meta_boxes', array( $this, 'add_metaboxes' ) );
		add_action( 'save_post', array( $this, 'quotebox_save_meta_box_data' ) );
	}

	/**
	 * Register the stylesheets for the Dashboard.
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

		//wp_enqueue_style( $this->quote_box, plugin_dir_url( __FILE__ ) . 'css/quote_box-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
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

		//wp_enqueue_script( $this->quote_box, plugin_dir_url( __FILE__ ) . 'js/quote_box-admin.js', array( 'jquery' ), $this->version, false );

	}

	function quote_box_register_post_types() {

		if ( class_exists( 'Quote_Box_Post_Type' ) ) {
			Quote_Box_Post_Type::create_quote();
			return true;
		} else {
			return false;
		}

	}

	function add_metaboxes () {

		add_meta_box('quotebox_employee', __('Name', 'QuoteBox'), array($this, 'quotebox_meta_box_employee_callback'), 'quotes', 'normal', 'default');
		add_meta_box('quotebox_jobtitle', __('Jobtitle', 'QuoteBox'), array($this, 'quotebox_meta_box_jobtitle_callback'), 'quotes', 'normal', 'default');
		add_meta_box('quotebox_page_id', __('Show only on', 'QuoteBox'), array($this, 'quotebox_meta_box_page_id_callback'), 'quotes', 'normal', 'default');

	}

	function quotebox_meta_box_jobtitle_callback( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'quotebox_meta_box_jobtitle', 'quotebox_meta_box_jobtitle_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$value = get_post_meta( $post->ID, 'quotebox_jobtitle', true );

		echo '
			<label for="quotebox_jobtitle">'
				. __( 'Jobtitle', 'QuoteBox' )
		  . '</label>

			<input type="text" id="quotebox_jobtitle" name="quotebox_jobtitle" value="' . esc_attr( $value ) . '" size="25" />';

	}

	function quotebox_meta_box_employee_callback( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'quotebox_meta_box_employee', 'quotebox_meta_box_employee_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$value = get_post_meta( $post->ID, 'quotebox_employee', true );

		echo '
			<label for="quotebox_employee">'
			. __( 'Naam', 'QuoteBox' )
		  . '</label>

		    <input type="text" id="quotebox_employee" name="quotebox_employee" value="' . esc_attr( $value ) . '" size="25" />';

	}

	function quotebox_meta_box_page_id_callback( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'quotebox_meta_box_page_id', 'quotebox_meta_box_page_id_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$selected = get_post_meta( $post->ID, 'quotebox_page_id', true );

		echo '<label for="quotebox_page_id">'
			. __( 'Show only on', 'QuoteBox' )
		  . '</label>

			<select id="quotebox_page_id" name="quotebox_page_id">
				<option value=""></option>';

		$categories = get_categories();

		foreach ($categories as $categorie) :
			echo '	<option value="' . $categorie->cat_ID . '"' . ($selected == $categorie->cat_ID ? ' selected' : '') . '>' . $categorie->name . '</option>';
		endforeach;

		$pages = get_pages();

		foreach ($pages as $page) :
			echo '	<option value="' . $page->ID . '"' . ($selected == $page->ID ? ' selected' : '') . '>' . $page->post_title . '</option>';
		endforeach;

		echo '</select>';

	}	

	/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */

	function quotebox_save_meta_box_data( $post_id ) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['quotebox_meta_box_jobtitle_nonce'] )
		|| ! isset( $_POST['quotebox_meta_box_employee_nonce'] )
		|| ! isset( $_POST['quotebox_meta_box_page_id_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['quotebox_meta_box_jobtitle_nonce'], 'quotebox_meta_box_jobtitle' )
		|| ! wp_verify_nonce( $_POST['quotebox_meta_box_employee_nonce'], 'quotebox_meta_box_employee' )
		|| ! wp_verify_nonce( $_POST['quotebox_meta_box_page_id_nonce'], 'quotebox_meta_box_page_id' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */
		
		// Make sure that it is set.
		if ( ! isset( $_POST['quotebox_jobtitle'] )
		|| ! isset( $_POST['quotebox_employee'] )
		|| ! isset( $_POST['quotebox_page_id'] ) ) {
			return;
		}

		// Sanitize user input.
		$jobtitle = sanitize_text_field( $_POST['quotebox_jobtitle'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, 'quotebox_jobtitle', $jobtitle );
		
		// Sanitize user input.
		$employee = sanitize_text_field( $_POST['quotebox_employee'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, 'quotebox_employee', $employee );

		// Sanitize user input.
		$page_id = sanitize_text_field( $_POST['quotebox_page_id'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, 'quotebox_page_id', $page_id );
	}
}
