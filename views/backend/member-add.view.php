<div class="wrap">
    <h1 class="wp-heading-inline">Add member</h1>
    
    <form action="" method="post">
        <table class="form-table">
            <input name="action" type="hidden" value="addmember">
            <tbody>
                <tr class="form-required">
                    <th scope="row">
                        <label for="first_name">First Name <span class="description">(required)</span></label>
                    </th>
                    <td>
                        <input name="first_name" type="text" id="first_name" value="<?php form_value('first_name'); ?>">
                    </td>
                </tr>
                <tr class="form-required">
                    <th scope="row">
                        <label for="last_name">Last Name <span class="description">(required)</span></label>
                    </th>
                    <td>
                       <input name="last_name" type="text" id="last_name" value=<?php form_value('last_name'); ?>"">
                    </td>
                </tr>
                <tr class="form-required">
                    <th scope="row">
                        <label for="email">Email <span class="description">(required)</span></label>
                    </th>
                    <td>
                       <input name="email" type="email" id="email" value="<?php form_value('email'); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="profession">Profession</label>
                    </th>
                    <td>
                       <input name="profession" type="text" id="profession" value="<?php form_value('profession'); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="bio">Bio</label>
                    </th>
                    <td>
                        <textarea name="bio" id="bio"><?php form_value('bio'); ?></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="createuser" id="createusersub" class="button button-primary" value="Add New Member">
        </p>
    </form>
</div>