<div>
    <div>
        <h2>Recipients</h2>
        <?php 
            if(!is_null($user_roles)){
                foreach($user_roles as $role){
                    
                }
            }

        ?>
    </div>
    <div>
        <h2>Send Email</h2>
        <form method="post">
            <span>
                <label for="tne-from">From</label>
                <input type="email" name="tne-from" id="tne-from">
            </span>
            <span>
                <label for="tne-subject">Subject</label>
                <input type="text" name="tne-subject" id="tne-subject">
            </span>
            <span>
                <label for="tne-message">Message</label>
                <?php wp_editor('', 'tne-message', ['textarea_name' => 'tne-message', 'teeny' => true, 'media_buttons' => false]); ?>
            </span>
            <button type="submit">Send</button>
        </form>
    </div>
    <div>
        <h2>History</h2>
        <table>
            <thead>
                <tr>
                    <td>Send Date</td>
                    <td>Subject</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>December 1st, 2017</td>
                    <td>11:11am</td>
                    <td>
                        <button>View</button>
                        <button>Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>