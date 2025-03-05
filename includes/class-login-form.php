<?php
// Login Form Handler Class
class CLRA_Login_Form {
    public function __construct() {
        add_shortcode('clra_login_form', array($this, 'render_login_form'));
        add_action('init', array($this, 'process_login'));
    }

    public function render_login_form() {
        ob_start(); ?>
        <form method="post">
            <label for="username">Username or Email</label>
            <input type="text" name="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <input type="submit" name="clra_login" value="Login">
        </form>
        <?php return ob_get_clean();
    }

    public function process_login() {
        if (isset($_POST['clra_login'])) {
            $username = sanitize_text_field($_POST['username']);
            $password = $_POST['password'];

            $user = get_user_by('login', $username);
            if (!$user) {
                $user = get_user_by('email', $username);
            }

            if ($user) {
                $account_status = get_user_meta($user->ID, 'clra_account_status', true);
                if ($account_status == 'approved') {
                    $creds = array(
                        'user_login' => $user->user_login,
                        'user_password' => $password,
                        'remember' => true
                    );
                    $user_signon = wp_signon($creds, false);
                    if (!is_wp_error($user_signon)) {
                        wp_redirect(home_url('/account'));
                        exit;
                    }
                } else {
                    wp_die('Your account is pending approval.');
                }
            } else {
                wp_die('Invalid login credentials.');
            }
        }
    }
}

new CLRA_Login_Form();
