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
        require_once TNE_PLUGIN_DIR . 'tne-options-page.php';
    }

    public static function ajaxSendEmails()
    {
        $response                       = [];
        $success                        = true;
        $message                        = '';
        
        $roles      = isset($_POST['tne-roles']) ? $_POST['tne-roles'] : null;
        $from       = isset($_POST['tne-from']) ? $_POST['tne-from'] : null;
        $subject    = isset($_POST['tne-subject']) ? $_POST['tne-subject'] : null;
        $body       = isset($_POST['tne-body']) ? $_POST['tne-body'] : null;

        // TO-DO: ADD ERROR MESSAGES AND GENERAL VALIDATION.
        $recipients = get_users([
            'role__in'  => $roles,
            'fields'    => ['id', 'user_email']
        ]);
        
        if(is_array($recipients) && count($recipients) > 0){
            
            $sent   = 0;
            $failed = 0;

            foreach($recipients as $recipient){
                
                $user_first_name    = get_user_meta($recipient->id, 'first_name', true);
                $user_last_name     = get_user_meta($recipient->id, 'last_name', true);
                $user_email         = $recipient->user_email;
                
                if(wp_mail("$user_first_name $user_last_name <$email>", $subject, $message)){
                    $response['recipients']['sent'][] = "$user_first_name $user_last_name <$email>";
                    $sent++;
                } else {
                    $response['recipients']['failed'][] = "$user_first_name $user_last_name <$email>";
                    $failed++;
                }
            }

            $response['message'] = "Sent {$sent} emails. Unable to send {$failed} emails.";
        }

        $response["result"]     = $success;
        $response["message"]    = $message;
        die(json_encode($response));
    }
}
