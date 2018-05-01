<script>
document.addEventListener('DOMContentLoaded', function(){

    var modal       = document.querySelector('#tne-modal-wrapper');
    var done_button = document.querySelector('#tne-modal-finished');

    var form    = document.querySelector('#tne-form');

    done_button.addEventListener('click', function(evt){
        evt.preventDefault();
        modal.style.display = 'none';
    });

    form.addEventListener('submit', function(evt){
        evt.preventDefault();
        modal.style.display = 'block';

        var formData = new FormData(this);
        formData.append('action', 'tne_send_email');

        var xhr = new XMLHttpRequest()
        xhr.open("POST", ajaxurl, true)

        xhr.onreadystatechange = function(){
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                done_button.style.display = 'block';
                done_button.disabled = false;
            }
        };

        xhr.send(formData);
    });
});

</script>
<style>
#tne-modal-wrapper{
    display: none;
    background-color: rgba(0, 0, 0, 0.75);
    position: absolute;
    top: 0;
    left: -20px;
    bottom: 0;
    right: 0;
    z-index: 998;
    padding-right: 20px;
}
    #tne-modal{
        width: 450px;
        background-color: #ddd;
        height: 250px;
        margin: auto;
        position: absolute;
        top: -400px;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 200;
        text-align: center;
    }
        #tne-modal h3{
            font-size: 2.5em;
            margin: 25px 0 20px 0;
            background-color: #663399;
            color: #fff;
            overflow: auto;
            padding: 25px;
        }
        #tne-modal img{
            width: 375px;
            margin: 30px 0;
        }
        #tne-modal button{
            padding: 20px 40px;
            font-size: 1.5em;
            display: none;
            margin: 35px auto;
        }
</style>
<div>
    <div>
        <div id="tne-modal-wrapper">
            <div id="tne-modal">
                <h3>Sending Emails</h3>
                <button type="button" id="tne-modal-finished" disabled>Done!</button>
                <div id="progress-indicator"></div>
            </div>
        </div>
        <form id="tne-form" method="post">
            <h2>Recipients</h2>
            <?php
if (!is_null($user_roles)) {
    foreach ($user_roles as $name) {
        ?>
                <label for="<?php echo $name; ?>"><?php echo $name; ?></label>
                <input id="<?php echo $name; ?>" name="tne-roles[]" type="checkbox" value="<?php echo $name; ?>">
            <?php
}
}
?>
        </div>
        <div>
            <h2>Send Email</h2>
            <span>
                <label for="tne-from">From</label>
                <input type="email" name="tne-from" id="tne-from">
            </span>
            <span>
                <label for="tne-subject">Subject</label>
                <input type="text" name="tne-subject" id="tne-subject">
            </span>
            <span>
                <label for="tne-body">Message</label>
                <?php wp_editor('', 'tne-body', ['textarea_name' => 'tne-body', 'teeny' => true, 'media_buttons' => false]);?>
            </span>
            <button type="submit">Send</button>
        </form>
    </div>
    <div>
        <h2>History</h2>
        <table>
            <thead>
                <tr>
                    <td>Sent</td>
                    <td>From</td>
                    <td>Subject</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
            <?php
               echo TinyNetworkEmailer::buildHistoryTableData();
            ?>
            </tbody>
        </table>
    </div>
</div>