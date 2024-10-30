<div class="wrap">
	<h1>Linkvertise Full Script API</h1>
	<?php settings_errors(); ?>

	<form method="post" action="options.php">
		<?php 
			settings_fields( 'linkvertise_script_api_options_group' );
			do_settings_sections( 'linkvertise_script_api_plugin' );
			submit_button();
		?>
	</form>
</div>