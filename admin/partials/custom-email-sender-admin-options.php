<?php
if((isset($_GET['output'])) && ($_GET['output'] === 'updated'))
{
    $notice = array('success', __('Your settings have been successfully updated.', 'custom-email-sender'));
}
elseif((isset($_GET['output'])) && ($_GET['output'] === 'error'))
{
    if((isset($_GET['type'])) && ($_GET['type'] === 'email'))
    {
        $notice = array('wrong', __('The email address is not valid !!', 'custom-email-sender'));
    }
    elseif((isset($_GET['type'])) && ($_GET['type'] === 'sender'))
    {
        $notice = array('wrong', __('The sender name is not valid !!', 'custom-email-sender'));
    }
    elseif((isset($_GET['type'])) && ($_GET['type'] === 'unknown'))
    {
        $notice = array('wrong', __('An unknown error occured !!', 'custom-email-sender'));
    }
}
?>
<div class="wrap">
    <section class="wpbnd-wrapper">
        <div class="wpbnd-container">
            <div class="wpbnd-tabs">
                <?php echo $this->return_plugin_header(); ?>
                <main class="tabs-main">
                    <?php echo $this->return_tabs_menu('tab1'); ?>
                    <section class="tab-section">
                        <?php if(isset($notice)) { ?>
                        <div class="wpbnd-notice <?php echo esc_attr($notice[0]); ?>">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo esc_attr($notice[1]); ?></span>
                        </div>
                        <?php } elseif((!isset($opts['sender-name'])) || (!isset($opts['sender-email']))) { ?>
                        <div class="wpbnd-notice warning">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo _e('You have not set up your sender name and email address ! In order to do so, please use the below form.', 'custom-email-sender'); ?></span>
                        </div>
                        <?php } else { ?>
                        <div class="wpbnd-notice info">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo _e('Your plugin is properly configured ! You can change at anytime your sender name and email address using the below form.', 'custom-email-sender'); ?></span>
                        </div>
                        <?php } ?>
                        <form method="POST">
                            <input type="hidden" name="ces-update-option" value="true" />
                            <?php wp_nonce_field('ces-referer-form', 'ces-referer-option'); ?>
                            <div class="wpbnd-form">
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Sender Name', 'custom-email-sender'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <input type="text" id="<?php echo esc_attr($fieldID); ?>" name="_custom_email_sender[sender-name]" placeholder="<?php echo _e('Enter the sender name', 'custom-email-sender'); ?>" value="<?php if(isset($opts['sender-name'])) { echo stripslashes($opts['sender-name']); } ?>" autocomplete="OFF" required="required"/>
                                    <small><?php echo _e('Enter the sender name as you want it to appear when email are sent (Min. 3 characters).', 'custom-email-sender'); ?></small>
                                </div>
                                <div class="field">
                                    <?php $fieldID = uniqid(); ?>
                                    <span class="label"><?php echo _e('Sender Email', 'custom-email-sender'); ?><span class="redmark">(<span>*</span>)</span></span>
                                    <input type="email" id="<?php echo esc_attr($fieldID); ?>" name="_custom_email_sender[sender-email]" placeholder="<?php echo _e('Enter the email address', 'custom-email-sender'); ?>" value="<?php if(isset($opts['sender-email'])) { echo sanitize_email($opts['sender-email']); } ?>" autocomplete="OFF" required="required"/>
                                    <small><?php echo _e('Enter the sender email as you want it to appear when email are sent (Must be a valid email address).', 'custom-email-sender'); ?></small>
                                </div>
                                <div class="form-footer">
                                    <input type="submit" class="button button-primary button-theme" style="height:45px;" value="<?php _e('Update Settings', 'custom-email-sender'); ?>">
                                </div>
                            </div>
                        </form>
                    </section>
                </main>
            </div>
        </div>
    </section>
</div>