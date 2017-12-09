<?php

class TinyNetworkEmailer
{

    public static function registerMenuHooks()
    {
        add_submenu_page('tools.php', 'Tiny Network Emailer', 'Tiny Network Emailer', 'manage_options', 'tiny-network-emailer', 'TinyNetworkEmailer::createOptionPage');
    }

    public static function createOptionPage()
    {
        require_once(TNE_PLUGIN_DIR . 'tne-options-page.php');
    }


}
