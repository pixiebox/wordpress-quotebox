<form action='options.php' method='post'>
			
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	
	<?php
	settings_fields( 'pluginPage' );
	do_settings_sections( 'pluginPage' );
	submit_button();
	?>
	
</form>