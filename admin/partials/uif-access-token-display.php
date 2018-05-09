<form method="post" action="options.php">
	<?php
		settings_fields( 'uif_options_group' );
		do_settings_sections( 'uif_options_group' );
		$access_token = sanitize_text_field(get_option('uif_access_token'));
	?>
	<table class="form-table">
		<tbody>
			
			<tr>
			<th scope="row"><label for="uif_button"><?php _e('Get Access Token',$this->plugin_name); ?></label></th>
				<td>
					<a class='button button-primary' href="https://api.instagram.com/oauth/authorize/?client_id=54da896cf80343ecb0e356ac5479d9ec&scope=basic+public_content&redirect_uri=http://api.web-dorado.com/instagram/?return_url=<?php echo urlencode(admin_url('admin.php?page=ultimate-instagram-feed.php')); ?>&response_type=token">Click here</a>
				</td>
			</tr>

			<tr>
			<th scope="row"><label for="uif_access_token"><?php _e('Access Token',$this->plugin_name); ?></label></th>
				<td>
					<input id='uif_access_token' type="text" class="regular-text" name="uif_access_token" value="<?php if($access_token != ''){echo $access_token;}elseif(isset($_GET['access_token'])){echo sanitize_text_field($_GET['access_token']);} ?>">
				</td>
			</tr>

		</tbody>
	</table>

	<?php submit_button(); ?>
</form>