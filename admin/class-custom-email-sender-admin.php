<?php
/**
 * The admin-specific functionality of the plugin
 *
 * @link https://sqoove.com
 * @since 1.0.0
 * @package Custom_Email_Sender
 * @subpackage Custom_Email_Sender/admin
*/

/**
 * Class `Custom_Email_Sender_Admin`
 * @package Custom_Email_Sender
 * @subpackage Custom_Email_Sender/admin
 * @author Sqoove <support@sqoove.com>
*/
class Custom_Email_Sender_Admin
{
	/**
	 * The ID of this plugin
	 * @since 1.0.0
	 * @access private
	 * @var string $pluginName the ID of this plugin
	*/
	private $pluginName;

	/**
	 * The version of this plugin
	 * @since 1.0.0
	 * @access private
	 * @var string $version the current version of this plugin
	*/
	private $version;

	/**
	 * Initialize the class and set its properties
	 * @since 1.0.0
	 * @param string $pluginName the name of this plugin
	 * @param string $version the version of this plugin
	*/
	public function __construct($pluginName, $version)
	{
		$this->pluginName = $pluginName;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area
	 * @since 1.0.0
	*/
	public function enqueue_styles()
	{
		wp_register_style($this->pluginName.'-fontawesome', plugin_dir_url(__FILE__).'assets/styles/fontawesome.min.css', array(), $this->version, 'all');
		wp_register_style($this->pluginName.'-dashboard', plugin_dir_url(__FILE__).'assets/styles/custom-email-sender-admin.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->pluginName.'-fontawesome');
		wp_enqueue_style($this->pluginName.'-dashboard');
	}

	/**
	 * Register the JavaScript for the admin area
	 * @since 1.0.0
	*/
	public function enqueue_scripts()
	{
		wp_register_script($this->pluginName.'-script', plugin_dir_url(__FILE__).'assets/javascripts/custom-email-sender-admin.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->pluginName.'-script');
	}

	/**
	 * Return the plugin header
	*/
	public function return_plugin_header()
	{
		$html = '<div class="wpbnd-header-plugin"><span class="header-icon"><i class="fas fa-sliders-h"></i></span> <span class="header-text">'.__('Custom Email Sender', 'custom-email-sender').'</span></div>';
		return $html;
	}

	/**
	 * Return the tabs menu
	*/
	public function return_tabs_menu($tab)
	{
		$link = admin_url('options-general.php');
		$list = array
		(
			array('tab1', 'custom-email-sender-admin', 'fa-cogs', __('Settings', 'custom-email-sender'))
		);

		$menu = null;
		foreach($list as $item => $value)
		{
			$html = array('div' => array('class' => array()), 'a' => array('href' => array()), 'i' => array('class' => array()), 'p' => array(), 'span' => array());
			$menu ='<div class="tab-label '.$value[0].' '.(($tab === $value[0]) ? 'active' : '').'"><a href="'.$link.'?page='.$value[1].'"><p><i class="fas '.$value[2].'"></i><span>'.$value[3].'</span></p></a></div>';
			echo wp_kses($menu, $html);
		}
	}

	/**
 	 * Return Email Address
	*/
	public function return_sender_email($old)
	{
		$opts = get_option('_custom_email_sender');

		if((isset($opts['sender-email'])) && (!empty($opts['sender-email'])) && ($opts['sender-email'] !== null))
		{
			return $opts['sender-email'];
		}
		else
		{
			return get_option('admin_email');
		}
	}

	/**
	 * Return Email Sender
	*/
	public function return_sender_name($old)
	{
		$opts = get_option('_custom_email_sender');

		if((isset($opts['sender-name'])) && (!empty($opts['sender-name'])) && ($opts['sender-name'] !== null))
		{
			return $opts['sender-name'];
		}
		else
		{
			return get_option('blogname');
		}
	}

	/**
	 * Update `Options` on form submit
	*/
	public function return_update_options()
	{
		if((isset($_POST['ces-update-option'])) && ($_POST['ces-update-option'] === 'true')
		&& check_admin_referer('ces-referer-form', 'ces-referer-option'))
		{
			$opts = array('sender-email' => null, 'sender-name' => null);
			if((isset($_POST['_custom_email_sender']['sender-email']))
			&& (isset($_POST['_custom_email_sender']['sender-name'])))
			{
				$opts['sender-email'] = sanitize_email($_POST['_custom_email_sender']['sender-email']);
				if(is_email($opts['sender-email']) === false)
				{
					header('location:'.admin_url('options-general.php?page=custom-email-sender-admin').'&output=error&type=email');
					die();
				}

				$opts['sender-name'] = sanitize_text_field($_POST['_custom_email_sender']['sender-name']);
				if((empty($opts['sender-name'])) || (strlen($opts['sender-name']) < 3))
				{
					header('location:'.admin_url('options-general.php?page=custom-email-sender-admin').'&output=error&type=sender');
					die();
				}

				$data = update_option('_custom_email_sender', $opts);
				header('location:'.admin_url('options-general.php?page=custom-email-sender-admin').'&output=updated');
				die();
			}
			else
			{
				header('location:'.admin_url('options-general.php?page=custom-email-sender-admin').'&output=error&type=unknown');
				die();
			}
		}
	}

	/**
	 * Return the `Options` page
	*/
	public function return_options_page()
	{
		$opts = get_option('_custom_email_sender');
		require_once plugin_dir_path(__FILE__).'partials/custom-email-sender-admin-options.php';
	}

	/**
	 * Return Backend Menu
	*/
	public function return_admin_menu()
	{
		add_options_page('Email Sender', 'Email Sender', 'manage_options', 'custom-email-sender-admin', array($this, 'return_options_page'));
	}
}

?>