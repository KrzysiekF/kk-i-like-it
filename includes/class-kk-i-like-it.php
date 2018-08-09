<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://krzysztof-furtak.pl
 * @since      2.0.0
 *
 * @package    Kk_I_Like_It
 * @subpackage Kk_I_Like_It/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.0.0
 * @package    Kk_I_Like_It
 * @subpackage Kk_I_Like_It/includes
 * @author     Krzysztof Furtak <krzysztof.furtak@gmail.com>
 */
class Kk_I_Like_It {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      Kk_I_Like_It_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'kk-i-like-it';

		$this->set_locale();
		$this->load_framework();
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Kk_I_Like_It_Loader. Orchestrates the hooks of the plugin.
	 * - Kk_I_Like_It_i18n. Defines internationalization functionality.
	 * - Kk_I_Like_It_Admin. Defines all hooks for the admin area.
	 * - Kk_I_Like_It_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-kk-i-like-it-i18n.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-kk-i-like-it-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-kk-i-like-it-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-kk-i-like-it-public.php';


		$this->loader = new Kk_I_Like_It_Loader();
	}

	private function load_framework() {
		if ( !class_exists( 'ReduxFramework' ) && file_exists( plugin_dir_path( dirname( __FILE__ ) ) . '/framework/ReduxCore/framework.php' ) ) {
			require_once  plugin_dir_path( dirname( __FILE__ ) ) . '/framework/ReduxCore/framework.php';
		}

		if ( !isset( $redux_demo ) && file_exists( plugin_dir_path( dirname( __FILE__ ) ) . '/options-config.php' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . '/options-config.php';
		}
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Kk_I_Like_It_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function set_locale() {

		// TODO: Wykminić dlaczego to nie działa
		// $plugin_i18n = new Kk_I_Like_It_i18n();
		// $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

		load_plugin_textdomain(
			'kk-i-like-it',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Kk_I_Like_It_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_head', $plugin_admin, 'head_variables' );
		$this->loader->add_action( 'wp_dashboard_setup', $plugin_admin, 'setup_wp_dashboard_widgets' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_page', 20 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Kk_I_Like_It_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_ajax_add_like', $plugin_public, 'add_like' );
		$this->loader->add_action( 'wp_ajax_nopriv_add_like', $plugin_public, 'add_like' );
		$this->loader->add_action( 'wp_ajax_remove_like', $plugin_public, 'remove_like' );
		$this->loader->add_action( 'wp_ajax_nopriv_remove_like', $plugin_public, 'remove_like' );

		$this->loader->add_action( 'the_content', $plugin_public, 'print_button' );
		$this->loader->add_action( 'the_content', $plugin_public, 'print_voters_section' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    2.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     2.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     2.0.0
	 * @return    Kk_I_Like_It_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     2.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
