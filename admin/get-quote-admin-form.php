<form method="post" name="cleanup_options" action="options.php">
    <?php
    settings_fields($this->plugin_name);
    do_settings_sections($this->plugin_name);
    ?>
    <p>This plugin use wp_mail() function to send emails.
        please ensure your wordpress is configured to send emails properly.</p>
    <?php submit_button('Save Email'); ?>
</form>