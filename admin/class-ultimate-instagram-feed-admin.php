<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       omark.me
 * @since      1.0.0
 *
 * @package    Ultimate_Instagram_Feed
 * @subpackage Ultimate_Instagram_Feed/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ultimate_Instagram_Feed
 * @subpackage Ultimate_Instagram_Feed/admin
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Ultimate_Instagram_Feed_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ultimate_Instagram_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Instagram_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ultimate-instagram-feed-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ultimate_Instagram_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Instagram_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ultimate-instagram-feed-admin.js', array( 'jquery' ), $this->version, false );
	    wp_localize_script( $this->plugin_name, 'uif_ajax_object',
	        array( 
	            'site_url' => get_site_url(),
	        )
	    );
	}


	// Making an option page in the settings page.
	public function uif_option_page(){
		add_options_page('Ultimate Instagram Feed','Ultimate Instagram Feed','manage_options',$this->plugin_name.'.php',array($this, 'uif_display_funcion'));
	}

	// Making tabs in the option page.
	private function uif_tabs(){
		return array(
			'access-token'=>'Access Token',
			'shortcodes'=>'Shortcodes',
			'developers'=>'Developers',
		);
	}

	// The display function that's required by the add_options_page function, it displays the HTML in the page.
	public function uif_display_funcion(){ ?>
		<div class="wrap">
		
			<div id="icon-themes" class="icon32"></div>
			<h2><?php _e( 'Ultimate Instagram Feed', $this->plugin_name ); ?></h2>
			
			<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'access-token'; ?>
			
			<h2 class="nav-tab-wrapper">
				<?php foreach($this->uif_tabs() as $key => $value){ ?>
					<a href="?page=<?php echo $this->plugin_name ?>.php&tab=<?php echo $key ?>" class="nav-tab <?php echo $active_tab == $key ? 'nav-tab-active' : ''; ?>"><?php echo _e($value,$this->plugin_name); ?></a>
				<?php } ?>
			</h2>

			<?php foreach($this->uif_tabs() as $key => $value){
				if($active_tab == $key){
					include_once('partials/uif-'.$key.'-display.php');
				}
			} ?>
			
		</div><!-- /.wrap -->
	<?php }


	// Register the plugin settings
	public function uif_register_settings(){
		// Keys and tokens
		register_setting( 'uif_options_group', 'uif_access_token'); 
	}


	// The ajax function that's called on clicking the generate shortcodes button, it generates the shortcodes obviously.
	public function uif_save_shortcodes(){
		$shortcode = sanitize_text_field($_POST['shortcode']);
		$shortcodes = get_option('uif_shortcodes');
		if($shortcodes != "" && is_array($shortcodes)){
			$shortcodes[] = $shortcode;
			update_option('uif_shortcodes',$shortcodes);
		}else{
			add_option('uif_shortcodes',array($shortcode));
		}
		$shortcodes = get_option('uif_shortcodes');
		$shortcodes = array_reverse($shortcodes);
		$output .= "<ul>";
		foreach($shortcodes as $shortcode){
			$shortcode = str_replace('\\','',$shortcode);
			$output .= "<li><input type='text' disabled value='".esc_attr($shortcode)."'/></li>";
		}
		$output .= "<ul>";
		echo $output;
		wp_die();
	}

	// The ajax function that's called on clicking the generate urls button, it generates the urls obviously.
	public function uif_save_urls(){
		$url = esc_url($_POST['url']);
		$urls = get_option('uif_urls');
		if($urls != "" && is_array($urls)){
			$urls[] = $url;
			update_option('uif_urls',$urls);
		}else{
			add_option('uif_urls',array($url));
		}
		$urls = get_option('uif_urls');
		$urls = array_reverse($urls);
		$output .= "<ul>";
		foreach($urls as $url){
			$url = str_replace('\\','',$url);
			$output .= "<li><input type='text' disabled value='".esc_attr($url)."'/></li>";
		}
		$output .= "<ul>";
		echo $output;
		wp_die();
	}


}
