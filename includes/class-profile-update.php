<?php
<?php

class CLRA_Profile_Update {
    public function __construct() {
        add_shortcode('clra_profile_update', array($this, 'render_profile_update_form'));
        add_action('init', array($this, 'process_profile_update'));
    }

    public function render_profile_update_form() {
        if (!is_user_logged_in()) {
            return '<p>Please <a href="' . wp_login_url() . '">login</a> to update your profile.</p>';
        }

        $current_user = wp_get_current_user();
        $billing_address = get_user_meta($current_user->ID, 'billing_address_1', true);

        ob_start(); ?>
        <form method="post">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo esc_attr($current_user->user_email); ?>" required>

            <label for="billing_address">Billing Address</label>
            <input type="text" name="billing_address" value="<?php echo esc_attr($billing_address); ?>" required>

            <input type="submit" name="clra_update_profile" value="Update Profile">
        </form>
        <?php return ob_get_clean();
    }

    public function process_profile_update() {
        if (isset($_POST['clra_update_profile']) && is_user_logged_in()) {
            $user_id = get_current_user_id();
            $email = sanitize_email($_POST['email']);
            $billing_address = sanitize_text_field($_POST['billing_address']);

            wp_update_user(array('ID' => $user_id, 'user_email' => $email));
            update_user_meta($user_id, 'billing_address_1', $billing_address);

            wp_redirect(home_url('/profile?updated=true'));
            exit;
        }
    }
}

new CLRA_Profile_Update();
