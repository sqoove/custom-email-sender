<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across the admin area
 *
 * @link https://sqoove.com
 * @since 1.0.0
 *
 * @package Custom_Email_Sender
 * @subpackage Custom_Email_Sender/includes
*/

/**
 * class `Custom_Email_Sender`
 * @since 1.0.0
 * @package Custom_Email_Sender
 * @subpackage Custom_Email_Sender/includes
 * @author Sqoove <support@sqoove.com>
*/
class Custom_Email_Sender
{
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power the plugin
	 * @since 1.0.0
	 * @access protected
	 * @var Custom_Email_Sender_Loader $loader maintains and registers all hooks for the plugin
	*/
	protected $loader;

	/**
	 * The unique identifier of this plugin
	 * @since 1.0.0
	 * @access protected
	 * @var string $pluginName the string used to uniquely identify this plugin
	*/
	protected $pluginName;

	/**
	 * The current version of the plugin
	 * @since 1.0.0
	 * @access protected
	 * @var string $version the current version of the plugin
	*/
	protected $version;

	/**
	 * Define the core functionality of the plugin
	 * @since 1.0.0
	*/
	public function __construct()
	{
		if(defined('CUSTOM_EMAIL_SENDER_VERSION'))
		{
			$this->version = CUSTOM_EMAIL_SENDER_VERSION;
		}
		else
		{
			$this->version = '1.0.0';
		}

		$this->pluginName = 'custom-email-sender';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
	}

	/**
	 * Load the required dependencies for this plugin
	 * @since 1.0.0
	 * @access private
	*/
	private function load_dependencies()
	{
		/**
		 * The class responsible for orchestrating the actions and filters of the core plugin
		*/
		require_once plugin_dir_path(dirname(__FILE__)).'includes/class-custom-email-sender-loader.php';

		/**
		 * The class responsible for defining internationalization functionality of the plugin
		*/
		require_once plugin_dir_path(dirname(__FILE__)).'includes/class-custom-email-sender-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area
		*/
		require_once plugin_dir_path(dirname(__FILE__)).'admin/class-custom-email-sender-admin.php';

		/**
		 * Loader
		*/
		$this->loader = new Custom_Email_Sender_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization
	 * @since 1.0.0
	 * @access private
	*/
	private function set_locale()
	{
		$pluginI18n = new Custom_Email_Sender_i18n();
		$this->loader->add_action('plugins_loaded', $pluginI18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality of the plugin
	 * @since 1.0.0
	 * @access private
	*/
	private function define_admin_hooks()
	{
		$pluginAdmin = new Custom_Email_Sender_Admin($this->get_pluginName(), $this->get_version());
		$allowed = array('custom-email-sender-admin');
		if((isset($_GET['page'])) && (in_array($_GET['page'], $allowed)))
		{
			$this->loader->add_action('admin_enqueue_scripts', $pluginAdmin, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $pluginAdmin, 'enqueue_scripts');
		}

		$this->loader->add_action('admin_menu', $pluginAdmin, 'return_admin_menu');
		$this->loader->add_action('init', $pluginAdmin, 'return_update_options');
		$this->loader->add_filter('wp_mail_from', $pluginAdmin, 'return_sender_email');
		$this->loader->add_filter('wp_mail_from_name', $pluginAdmin, 'return_sender_name');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress
	 * @since 1.0.0
	*/
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 * @since 1.0.0
	 * @return string the name of the plugin
	*/
	public function get_pluginName()
	{
		return $this->pluginName;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin
	 * @since 1.0.0
	 * @return Custom_Email_Sender_Loader orchestrates the hooks of the plugin
	*/
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin
	 * @since 1.0.0
	 * @return string the version number of the plugin
	*/
	public function get_version()
	{
		return $this->version;
	}
}

?>