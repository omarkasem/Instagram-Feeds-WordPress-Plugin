<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       omark.me
 * @since      1.0.0
 *
 * @package    Ultimate_Instagram_Feed
 * @subpackage Ultimate_Instagram_Feed/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ultimate_Instagram_Feed
 * @subpackage Ultimate_Instagram_Feed/public
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Ultimate_Instagram_Feed_Public {


	private $access_token;
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->access_token = get_option('uif_access_token');


        add_action('rest_api_init', array($this,'uif_by_name_route'));

	}

	public function uif_by_name_route(){
	    register_rest_route('uif', '/uif_by_name/(?P<username>[a-zA-Z0-9-_.]+)/(?P<number>\d+)', array(
	        'methods' => 'GET',
	        'callback' => array($this, 'uif_get_insts_by_user_in_json'),
		));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ultimate-instagram-feed-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ultimate-instagram-feed-public.js', array( 'jquery' ), $this->version, false );

	}


	private function get_insts_by_user($username,$number){

	    $username = 'https://api.instagram.com/v1/users/self/?access_token='.$this->access_token.'';
	    $username = file_get_contents($username);
	    $username = json_decode($username);
	    $user_id = $username->data->id;
	    $api_url = 'https://api.instagram.com/v1/users/'.intval($user_id).'/media/recent/?access_token='.$this->access_token.'&count='.$number.'';
	    $api_url = file_get_contents($api_url);
	    $api_url = json_decode($api_url);
	    if(!empty($api_url)){
	    	$insts = $api_url->data;
	    	return $insts;
		}
	}


    public function shortcode_by_user($atts)
    {
        extract(shortcode_atts(array(
            'username' => '',
            'number' => '',
            'version' => '',
        ), $atts));

        $insts = $this->get_insts_by_user($atts['username'], $atts['number']);
        return $this->html_shortcode($insts,$atts['version']);
    }


	private function html_shortcode($insts=array(),$version = 1){
		if($this->access_token != ''){
			if(!empty($insts) && is_array($insts)){
				if($version == 1){
					$output = '';
					$caption = '';
					foreach($insts as $inst){
						$image_url = $inst->images->thumbnail->url;
						if($inst->caption != null){$caption = $inst->caption->text;}
						$output .= "<div class='uif_inst_block uif_3_blocks'>";
						$output .= "<a target='_blank' href='".$inst->link."'>";
						$output .= "<img src='".$image_url."' alt='".$caption."'>";
						$output .= "</a>";
						$output .= "</div>";
					}
					$output .= "<div class='uif_button'><a href='https://www.instagram.com/".$insts[0]->user->username."'>More</a></div>";
					return $output;
				}
			}else{
				return "Instagram account has no feeds !";
			}
		}else{
			return "Please fill the access token field !";
		}
	}


    public function uif_get_insts_by_user_in_json($data)
    {
        $insts = $this->get_insts_by_user($data['username'], $data['number']);
        return $this->uif_json_array($insts);
    }

    public function uif_json_array($insts=array()){
		if($this->access_token != ''){
			if(!empty($insts) && is_array($insts)){
				foreach($insts as $inst){
					$time = date('M j, Y', $inst->created_time);
					$array[] = (object)array(
						'id'=> $inst->user->id,
						'full_name'=> $inst->user->full_name,
						'link'=>$inst->link,
						'profile_picture'=> $inst->user->profile_picture,
						'username'=> $inst->user->username,
						'created_at'=> $time,
						'caption'=> $inst->caption->text,
						'images'=> array(
							'thumbnail'=>$inst->images->thumbnail->url,
							'medium'=>$inst->images->low_resolution->url,
							'large'=>$inst->images->standard_resolution->url,
						),
						'likes'=>$inst->likes->count,
						'comments'=>$inst->comments->count,
						// 'location' =>$inst->location->name,
					);
				}
				return $array;
			}else{
				return "Instagram account has no feeds !";
			}
		}else{
			return "Please fill the access token field !";
		}
    }



}
