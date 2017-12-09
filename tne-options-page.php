<style>
    .tne-wrapper {
        width: 80%;
        margin: 0 auto;
        max-width: 1200px;
        box-sizing: border-box;
        padding: 50px 25px;
    }

    .tne-wrapper .section {
        padding: 30px 50px;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        overflow: auto; 
        margin-bottom: 40px;
        -webkit-box-shadow: 3px 3px 0px 1px rgba(26, 193, 193, 1);
        -moz-box-shadow: 3px 3px 0px 1px rgba(26, 193, 193, 1);
        box-shadow: 3px 3px 0px 1px rgba(26, 193, 193, 1);
    }

    .tne-wrapper h2 {
        font-size: 3.5em;
        width: 35%;
        margin: 20px 0 35px 0;
    }

    .tne-wrapper .field-wrapper {
        display: block;
        width: 100%;
        margin: 15px 0;
    }

    .tne-wrapper .field-wrapper label {
        display: block;
        width: 100%;
        font-size: 1.75em;
        font-weight: 800;
        padding: 10px 0 10px 2px;
    }

    .tne-wrapper .field-wrapper input {
        padding: 7px;
        width: 100%;
        max-width: 400px;
        border-bottom: 5px solid #1ac1c1;
    }
</style>
<div class="tne-wrapper">
    <div class="section">
        <h2>Recipients</h2>
    </div>
    <div class="section">
        <h2>Send Email</h2>
        <form method="post">
            <span class="field-wrapper">
                <label for="tne-from">From</label>
                <input type="email" name="tne-from" id="tne-from">
            </span>
            <span class="field-wrapper">
                <label for="tne-subject">Subject</label>
                <input type="text" name="tne-subject" id="tne-subject">
            </span>
            <span class="field-wrapper">
                <label for="tne-message">Message</label>
                <?php wp_editor('', 'tne-message', ['textarea_name' => 'tne-message', 'teeny' => true, 'media_buttons' => false]); ?>
            </span>
        </form>
    </div>
    <div class="section">
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
                        <button class="tne-action-view">View</button>
                        <button class="tne-action-delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>