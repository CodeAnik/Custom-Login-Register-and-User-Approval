<?php

// User Approval Class
class CLRA_User_Approval {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_post_clra_approve_user', array($this, 'approve_user'));
    }

    public function add_admin_menu() {
        add_menu_page('User Approval', 'User Approval', 'manage_options', 'clra-user-approval', array($this, 'approval_page'));
    }

    public function approval_page() {
        $users = get_users(array('meta_key' => 'clra_account_status', 'meta_value' => 'pending'));
        echo '<h2>Pending User Approvals</h2>';
        echo '<table><tr><th>Username</th><th>Email</th><th>Action</th></tr>';
        foreach ($users as $user) {
            echo '<tr><td>' . esc_html($user->user_login) . '</td><td>' . esc_html($user->user_email) . '</td>';
            echo '<td><a href="' . admin_url('admin-post.php?action=clra_approve_user&user_id=' . $user->ID) . '">Approve</a></td></tr>';
        }
        echo '</table>';
    }

    public function approve_user() {
        if (isset($_GET['user_id'])) {
            $user_id = intval($_GET['user_id']);
            update_user_meta($user_id, 'clra_account_status', 'approved');
            wp_redirect(admin_url('admin.php?page=clra-user-approval'));
            exit;
        }
    }
}

new CLRA_User_Approval();
