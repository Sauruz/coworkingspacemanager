<table class="form-table">
    <tbody>
        <tr class="form-required">
            <th scope="row">
                <label for="first_name">First Name <span class="description">(required)</span></label>
            </th>
            <td>
                <input name="first_name" type="text" id="first_name" value="<?php form_value($data, 'first_name'); ?>">
            </td>
        </tr>
        <tr class="form-required">
            <th scope="row">
                <label for="last_name">Last Name <span class="description">(required)</span></label>
            </th>
            <td>
                <input name="last_name" type="text" id="last_name" value="<?php form_value($data, 'last_name'); ?>">
            </td>
        </tr>
        <tr class="form-required">
            <th scope="row">
                <label for="email">Email <span class="description">(required)</span></label>
            </th>
            <td>
                <input name="email" type="email" id="email" value="<?php form_value($data, 'email'); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="profession">Profession</label>
            </th>
            <td>
                <input name="profession" type="text" id="profession" value="<?php form_value($data, 'profession'); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="bio">Bio</label>
            </th>
            <td>
                <textarea name="bio" id="bio"><?php form_value($data, 'bio'); ?></textarea>
            </td>
        </tr>
    </tbody>
</table>