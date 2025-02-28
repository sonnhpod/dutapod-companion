<h1>Manage all settings for the plugin dutapod-companion</h1>

<!-- Display if there is any error after submitting the form. -->
<?php settings_errors(); ?>

<form method="post" action="options.php" class="dutapod-companion-general-form">
    <!-- 1. Specify setting groups. This will include a hidden form -->
    <!-- This function will generate reference to the custom admin page -->
    <?php settings_fields( 'dutapod-companion-settings-group' ); ?>

    <!-- 2. Implement the settings for a specific page - using slug -->
    <!-- Using the value menu_slug of the troubleshoot page -->
    <?php do_settings_sections( 'dutapod-companion_plugin_troubleshoot' ); ?> 

    <!-- 3. Output a HTML data for the submit button -->
    <?php submit_button( 'Save your changes' , 'primary' , 'custom-submit-button' ); ?> 
</form>


