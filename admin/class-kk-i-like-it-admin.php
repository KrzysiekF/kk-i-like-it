<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://krzysztof-furtak.pl
 * @since      1.0.0
 *
 * @package    Kk_I_Like_It
 * @subpackage Kk_I_Like_It/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kk_I_Like_It
 * @subpackage Kk_I_Like_It/admin
 * @author     Krzysztof Furtak <krzysztof.furtak@gmail.com>
 */
class Kk_I_Like_It_Admin {

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

	private $titan;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->load_dependencies();
		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// $this->titan = TitanFramework::getInstance( $this->plugin_name );
	}

	private function load_dependencies() {}

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
		 * defined in Kk_I_Like_It_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kk_I_Like_It_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name . '-charts', plugin_dir_url( __FILE__ ) . 'js/libs/chartist/dist/chartist.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kk-i-like-it-admin.css', array(), $this->version, 'all' );

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
		 * defined in Kk_I_Like_It_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kk_I_Like_It_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name . '-charts', plugin_dir_url( __FILE__ ) . 'js/libs/chartist/dist/chartist.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-moment', plugin_dir_url( __FILE__ ) . 'js/libs/moment.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kk-i-like-it-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function admin_page() {
		add_submenu_page(
			'kk-i-like-it-2',
			'Statistics',
			'Statistics',
			'manage_options',
			'kk-i-like-it-stats',
			array( $this, 'create_admin_page' )
		);
	}

	public function create_admin_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/kk-i-like-it-admin-display.php';
	}

	public function head_variables() {
		global $kk_like_options;

		?>
		<script type="text/javascript">
			var likeText = '<?php echo $kk_like_options['kklike-like-text']; ?>';
			var unlikeText = '<?php echo $kk_like_options['kklike-unlike-text']; ?>';
		</script>
		<?php
	}

	public function recently_liked_widget() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/widget-recently-liked.php';
	}

	public function most_liked_widget() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/widget-most-liked.php';
	}

	public function setup_wp_dashboard_widgets() {
		global $kk_like_options;
		
		if($kk_like_options['kklike-show-recent-liked'] === '2'){
			wp_add_dashboard_widget('recently_liked_dashboard_widget', __('KKILikeIt - recently liked', 'lang-kklike'), array($this, 'recently_liked_widget'));
		}	
		if($kk_like_options['kklike-show-top-liked'] === '2'){
			wp_add_dashboard_widget('most_liked_dashboard_widget', __('KKILikeIt - most liked - TOP 5', 'lang-kklike'), array($this, 'most_liked_widget'));
		}
	}

}
