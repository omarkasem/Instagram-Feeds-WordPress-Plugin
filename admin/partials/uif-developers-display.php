<div class="uif-col-<?php if(is_rtl()){echo 'right';}else{echo 'left';} ?>">
<form method="post" action="" id="uif_url_form">
	<table class="form-table">
		<tbody>

			<tr>
			<th scope="row"><label for="uif_type_of_feed"><?php _e('Type of the feed',$this->plugin_name); ?></label></th>
				<td>
					<select name="uif_type_of_feed" class="uif_type_of_feed">
						<option value=""><?php _e('Types',$this->plugin_name); ?></option>
						<option value="by_name"><?php _e('By Username',$this->plugin_name); ?></option>
					</select>
				</td>
			</tr>
			
			<tfoot id="div_by_name" style="display: none;">
				<tr>
				<th scope="row"><label for="uif_username"><?php _e('Instgaram Username',$this->plugin_name); ?></label></th>
					<td>
						<input  type="text" id="uif_username">
					</td>
				</tr>

				<tr>
				<th scope="row"><label for="uif_inst_number"><?php _e('Number of Photos',$this->plugin_name); ?></label></th>
					<td>
						<input value="5" type="number" id="uif_inst_number">
					</td>
				</tr>


			</tfoot>

			
		</tbody>
	</table>
	<input style="display: none;" type="submit" id="generate_button" class="button button-primary" value="<?php _e('Generate URLS',$this->plugin_name); ?>">
</form>
<h2><?php _e('Generated WP REST URLS',$this->plugin_name); ?></h2>
<div id="uif_urls_div">
	<?php
		if(isset($_POST['reset_urls']) && check_admin_referer( 'uif_reset_urls_nonce') && current_user_can('manage_options') ){
			delete_option('uif_urls');
		}
		$urls = get_option('uif_urls');
		$output = "";
		if($urls != "" && is_array($urls)){
			$urls = array_reverse($urls);
			$output .= "<ul>";
			foreach($urls as $url){
				$url = str_replace('\\','',$url);
				$output .= "<li><input type='text' disabled value='".esc_attr($url)."'/></li>";
			}
			$output .= "<ul>";
			echo $output; ?>
		<?php } ?>
</div>
<?php if($urls != "" && is_array($urls)){ ?>
<form action="" method="post">
	<?php wp_nonce_field( 'uif_reset_urls_nonce'); ?>
	<input type="submit" class="button button-primary" value="<?php _e('Reset URLS',$this->plugin_name); ?>" name="reset_urls">
</form>
<?php } ?>
</div>
