<?php
/**
 * Fired during plugin deactivation
 *
 * @link https://neoslab.com
 * @since 1.0.0
 *
 * @package Custom_Email_Sender
 * @subpackage Custom_Email_Sender/includes
*/

/**
 * Class `Custom_Email_Sender_Deactivator`
 * This class defines all code necessary to run during the plugin's deactivation
 * @since 1.0.0
 * @package Custom_Email_Sender
 * @subpackage Custom_Email_Sender/includes
 * @author NeosLab <contact@neoslab.com>
*/
class Custom_Email_Sender_Deactivator
{
	/**
	 * Deactivate plugin
	 * @since 1.0.0
	*/
	public static function deactivate()
	{
		$option = delete_option('_custom_email_sender');
	}
}

?>