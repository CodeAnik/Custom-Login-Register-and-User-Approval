<?php
// Register Form Handler Class
class CLRA_Register_Form {
    public function __construct() {
        add_shortcode('clra_register_form', array($this, 'render_register_form'));
        add_action('init', array($this, 'process_registration'));
    }

    public function render_register_form() {
        ob_start(); ?>
        <form method="post">
            <label for="username">Username</label>
            <input type="text" name="username" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <label for="billing_address">Billing Address</label>
            <input type="text" name="billing_address" required>

            <input type="submit" name="clra_register" value="Register">
        </form>
        <?php return ob_get_clean();
    }

    public function process_registration() {
        if (isset($_POST['clra_register'])) {
            $username = sanitize_text_field($_POST['username']);
            $email = sanitize_email($_POST['email']);
            $password = $_POST['password'];
            $billing_address = sanitize_text_field($_POST['billing_address']);

            $user_id = wp_create_user($username, $password, $email);
            if (!is_wp_error($user_id)) {
                update_user_meta($user_id, 'billing_address_1', $billing_address);
                update_user_meta($user_id, 'clra_account_status', 'pending');
                wp_redirect(home_url('/thank-you'));
                exit;
            }
        }
    }
}

new CLRA_Register_Form();