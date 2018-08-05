<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://krzysztof-furtak.pl
 * @since      2.0.0
 *
 * @package    Kk_I_Like_It
 * @subpackage Kk_I_Like_It/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Kk_I_Like_It
 * @subpackage Kk_I_Like_It/public
 * @author     Krzysztof Furtak <krzysztof.furtak@gmail.com>
 */
class Kk_I_Like_It_Public {

	private $db;

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->load_dependencies();
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->db = new Kk_I_Like_It_DB();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-kk-i-like-it-db.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/widgets.php';

	}

	private function set_button_position($content, $button) {
		global $kk_like_options;

		switch ($kk_like_options['kklike-button-position']) {
			case '1':
				return $button . $content;

			case '2':
				return $button . $content;
			
			case '3':
				return $content . $button;

			case '4':
				return $content . $button;

			default:
				return $button . $content;
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_styles() {
		global $kk_like_options;
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kk_I_Like_It_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kk_I_Like_It_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kk-i-like-it-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-button-base', plugin_dir_url( __FILE__ ) . 'css/kk-i-like-it-button-base.css', array(), $this->version, 'all' );

		if (!$kk_like_options['kklike-own-button-style']) {
			wp_enqueue_style( $this->plugin_name . '-theme', plugin_dir_url( __FILE__ ) . 'css/themes/'. $kk_like_options['kklike-button-type'] .'.css', array(), $this->version, 'all' );
		} else {
			wp_enqueue_style( $this->plugin_name . '-theme', plugin_dir_url( __FILE__ ) . 'css/generate-style.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kk_I_Like_It_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kk_I_Like_It_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kk-i-like-it-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'kk-i-like-it', 'kkajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	public function print_button($content) {
		global $post;
		global $kk_like_options;
		$canDisplayButton = true;
		$showRating = true;
		$boxRating = '';
		$boxRatingHTML = '';

		if ($kk_like_options['kklike-where-display'] == '2') {
			$canDisplayButton = is_page();
		} else if ($kk_like_options['kklike-where-display'] == '1') {
			$canDisplayButton = is_single();
		}

		if ($kk_like_options['kklike-button-position'] === '5') {
			$canDisplayButton = false;
		}

		if ($kk_like_options['kklike-show-on-post-list'] === '1') {
			$canDisplayButton = !is_home();
		}
	
		// $disableButton = get_post_meta($post->ID, 'post_display_likes_button_value', true);		

		if (!$canDisplayButton) {
			return $content;
		}
		
		if(!is_user_logged_in() && $kk_like_options['kklike-show-button-guest'] == '1'){
			return $content;
		}

		$rating = $this->db->getPostRating($post->ID, 'post');

		if ($kk_like_options['kklike-show-like-number'] === '1') {
		} else if ($kk_like_options['kklike-show-like-number'] == '3') {
			$boxRating = 'kk-i-like-it__rating-hover';		
		}else if ($kk_like_options['kklike-show-like-number'] === '2') {
			$showRating = false;
			$boxRating = 'kk-i-like-it__rating-hidden';
		}

		$isLike = $this->db->checkIsLike($post->ID);
		$userRate = $this->db->checkUserRating($post->ID, get_current_user_id(), $_SERVER['REMOTE_ADDR']);
		$action = '';
		
		if($userRate == '0'){
			$action = 'like';
			$text = $kk_like_options['kklike-like-text'];
		}else{
			$action = 'unlike';
			$text = $kk_like_options['kklike-unlike-text'];
		}

		$positionClass = 'kk-i-like-it__left';

		if (
			$kk_like_options['kklike-button-position'] === '2'
			|| $kk_like_options['kklike-button-position'] === '4'
		) {
			$positionClass = 'kk-i-like-it__right';
		}
	
		if($kk_like_options['kklike-only-users'] == '2'){
			$onlyUser = '1';
		}else{
			$onlyUser = '0';
		}

		if(empty($rating)){
			$rating = 0;
		}

		if ($showRating) {
			$boxRatingHTML = '
				<span class="kk-i-like-it__value">
					<span>'. $rating .'</span>
				</span>
			';
		}

		$kklike = '
		<div class="kk-i-like-it__box '. $positionClass .'">
			<button
				class="'. $boxRating .'"
				data-post-id="'. $post->ID .'"
				data-post-type="post"
				data-action="'. $action .'"
				data-user="'. get_current_user_id() .'"
				data-ou="'. $onlyUser .'"
				rel="kk-i-like-it--post-'. $post->ID .'"
			>
				<span class="kk-i-like-it__ico">
					<span>
						<svg class="icon icon-heart2" viewBox="0 0 28 28" width="28" height="28">
							<path d="M14 26c-0.25 0-0.5-0.094-0.688-0.281l-9.75-9.406c-0.125-0.109-3.563-3.25-3.563-7 0-4.578 2.797-7.313 7.469-7.313 2.734 0 5.297 2.156 6.531 3.375 1.234-1.219 3.797-3.375 6.531-3.375 4.672 0 7.469 2.734 7.469 7.313 0 3.75-3.437 6.891-3.578 7.031l-9.734 9.375c-0.187 0.187-0.438 0.281-0.688 0.281z"></path>
						</svg>
					</span>
				</span> 
				'. $boxRatingHTML .'
				<span class="kk-i-like-it__text">
					<span>'. $text .'</span>
				</span>
			</button>
		</div>
		';

		return $this->set_button_position($content, $kklike);
	}

	public function add_like() {
		global $kk_like_options;

		$user = get_current_user_id();
		
		if($kk_like_options['kklike-only-users'] == '2' && $user == '0'){
			$odp = array('hasError' => TRUE, 'rating' => '', 'msg' => 'Only registered users can vote.');
			echo json_encode($odp);
			die();
		}
		
		$data = $this->db->addLike($_POST['idPost'], $user, $_POST['type']);
		echo $data;
		
		die();
	}

	public function remove_like() {
		$user = get_current_user_id();
	
		$data = $this->db->removeLike($_POST['idPost'], $user, $_POST['type']);
		echo $data;
		
		die();
	}

	public function print_voters_section($content) {
		global $post, $kk_like_options;

		$dane = $this->db->getPostVoters($post->ID);
		$users = '';

		if(count($dane) > 0 && is_single() && $kk_like_options['kklike-show-voters-section'] === '2'){
			if($kk_like_options['kklike-voters-header'] !== ''){
				$users .= '<h3 class="kk-i-like-it__header">' . $kk_like_options['kklike-voters-header'] . '</h3>';
			}
			
			foreach($dane as $user){
				if(!empty($user->display_name)){
					$nick = $user->display_name;
				}else{
					$nick = __('Guest');
				}

				$nick = ($kk_like_options['kklike-show-voters-names'] === '2')? $nick : '';

				$users .= '<span class="kk-i-like-it__user-box">' 
						. get_avatar( $user->ID, $size = (!empty($kk_like_options['kklike-avatar-size'])) ? $kk_like_options['kklike-avatar-size'] : '50' )
						. '<span class="kk-i-like-it__user-nick">'. $nick .'</span>' 
						. '</span>';
			}
		}else{
			$users = '';
		}

		return $content . $users;
	}
}
