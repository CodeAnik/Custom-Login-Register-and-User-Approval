<?php
<?php

class CLRA_Settings {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_settings_page() {
        add_options_page('Custom Login Register Settings', 'CLRA Settings', 'manage_options', 'clra-settings', array($this, 'settings_page'));
    }

    public function settings_page() {
        ?>
        <div class="wrap">
            <h2>Custom Login Register Settings</h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('clra_settings_group');
                do_settings_sections('clra-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        register_setting('clra_settings_group', 'clra_registration_redirect');
        add_settings_section('clra_main_section', 'Main Settings', null, 'clra-settings');

        add_settings_field(
            'clra_registration_redirect',
            'Registration Redirect URL',
            array($this, 'registration_redirect_field'),
            'clra-settings',
            'clra_main_section'
        );
    }

    public function registration_redirect_field() {
        $value = get_option('clra_registration_redirect', home_url());
        echo '<input type="text" name="clra_registration_redirect" value="' . esc_attr($value) . '" class="regular-text">';
    }
}

new CLRA_Settings();
