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
        $response = [];

        $roles = isset($_POST['tne-roles']) ? $_POST['tne-roles'] : null;
        $from = isset($_POST['tne-from']) ? $_POST['tne-from'] : null;
        $subject = isset($_POST['tne-subject']) ? $_POST['tne-subject'] : null;
        $body = isset($_POST['tne-body']) ? $_POST['tne-body'] : null;

        // TO-DO: ADD ERROR MESSAGES AND GENERAL VALIDATION.
        $recipients = get_users([
            'role__in' => $roles,
            'fields' => ['id', 'user_email'],
        ]);

        if (is_array($recipients) && count($recipients) > 0) {

            $sent = 0;
            $failed = 0;

            foreach ($recipients as $recipient) {

                $user_first_name = get_user_meta($recipient->id, 'first_name', true);
                $user_last_name = get_user_meta($recipient->id, 'last_name', true);
                $user_email = $recipient->user_email;

                $headers[] = "From: $from";

                if (wp_mail("$user_first_name $user_last_name <$user_email>", $subject, $body, $headers)) {
                    $response['recipients']['sent'][] = "$user_first_name $user_last_name <$user_email>";
                    $sent++;
                } else {
                    $response['recipients']['failed'][] = "$user_first_name $user_last_name <$user_email>";
                    $failed++;
                }
            }
            $response['result'] = true;
            $response['message'] = "Sent {$sent} emails. Unable to send {$failed} emails.";
            $response['uid'] = self::updateHistory($response, $from, $subject, $body);
        }
        die(json_encode($response));
    }

    public static function buildHistoryTableData($page = 1, $per_page = 2)
    {
        $output = '';
        $history_manager = get_site_option('tne-history-manager', null);

        

        if (is_array($history_manager['records']) && count($history_manager['records']) > 0) {
            
            $offset = ($page - 1) * $per_page;
            $total_pages = ceil(count($history_manager['records'] / $per_page));
             
            foreach ($history_manager['records'] as $history_entry) {
                $output .= "
                <tr>
                    <td>{$history_entry['date_time']}</td>
                    <td>{$history_entry['from']}</td>
                    <td>{$history_entry['subject']}</td>
                    <td><button data-uid={$history_entry['uid']}>View</button><button data-uid={$history_entry['uid']}>Delete</button></td>
                </tr>
                ";
            }
        } else {
            $output .= "
            <tr>
                <td colspan=4>There is currently no history to display.</td>
            </tr>
            ";
        }
        return $output;
    }

    private static function updateHistory($response, $from, $subject, $body)
    {
        $history_manager = [];
        $history_manager = get_site_option('tne-history-manager', null);

        $date = date("Y-m-d H:i:s");
        $uid = md5($date . $subject);

        $new_history_record = [
            'uid' => $uid,
            'date_time' => $date,
            'recipients' => $response,
            'from' => $from,
            'subject' => $subject,
            'body' => $body,
        ];

        if (is_null($history_manager)) {
            $history_manager = [
                'records' => [],
            ];
        }

        $history_manager['records'][] = $new_history_record;
        update_site_option('tne-history-manager', $history_manager);
    }
}
