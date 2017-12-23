<?php

class TinyNetworkEmailer
{

    public static function registerMenuHooks()
    {
        add_submenu_page('tools.php', 'Tiny Network Emailer', 'Tiny Network Emailer', 'manage_options', 'tiny-network-emailer', 'TinyNetworkEmailer::createOptionPage');
    }

    public static function createOptionPage()
    {
        $user_roles = wp_roles()->get_names();
        require_once(TNE_PLUGIN_DIR . 'tne-options-page.php');
    }


}
