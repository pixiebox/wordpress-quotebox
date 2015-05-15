<?php
// sunny-demo/admin/views/admin.php

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
 
	 	<form action="options.php" method="POST">
	  		<?php $plugin = Quote_Box::get_instance(); ?>
	  		<?php $plugin_slug = $plugin->get_plugin_slug(); ?>
	  		<?php settings_fields( 'sunny_demo_cloudflare_account_section' ); ?>
	  		<?php do_settings_sections( $plugin_slug ); ?>
	  		<?php submit_button( __('Save', $plugin_slug ) ); ?>
	  		</form>
</div>