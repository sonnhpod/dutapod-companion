<h1>Manage all of the plugin settings</h1>

<!-- Display if there is any error after submitting the form. -->
<!-- Obtain the "SettingsSubpage class properties from $settingsSubpage variable -->
<?php 
// 1. Extract data from $settingSubpage

/**
 * 1. Validate $settingsSubpage - OK
 * 
*/

// Settings data
$settingData = $settingsSubpage->settingsData[0];
// $optionGroup = $settingData['option_group'];
// $optionName = $settingData['option_name'];

// Section data
$sectionData = $settingsSubpage->sectionsData[0];
// $sectionID = $sectionData['id'];

$fieldData = $settingsSubpage->fieldsData[0];

?>

<?php settings_errors(); ?>

<?php // var_dump( $fieldData ); ?>

<!-- 1. Form that manage Wordpress settings, sections, and fields for the current submenu "settings page" -->
<!-- Setting API documentation: https://developer.wordpress.org/plugins/settings/settings-api/  -->
<form method="post" action="options.php" class="dutapod-companion-general-form">
    <!-- 1. Specify setting groups. This will include a hidden form -->
    <!-- This function will generate reference to the custom admin page -->
    <!-- Relevant API documentation: https://developer.wordpress.org/reference/functions/settings_fields/  -->
    <?php // settings_fields( 'dutapod-companion-settings-group' ); ?>
    <h3>Render HTML content for Settings fields</h3>
    <?php settings_fields(  $settingData['option_group'] ); ?>

    <!-- 2. Implement the settings for a specific page - using slug -->
    <!-- Using the value menu_slug of the troubleshoot page -->
    <!-- Relevant API documentation: https://developer.wordpress.org/reference/functions/do_settings_sections/ -->
    <?php // do_settings_sections( 'dutapod-companion_plugin_troubleshoot' ); ?> 
    <h3>Render HTML content of the setting section for a specific page</h3>
    <?php do_settings_sections(  $settingsSubpage->menu_slug ); ?> 

    <!-- 3. Render the settings field registered at the specific section of the specific page -->
    <!-- Relevant API documentation: https://developer.wordpress.org/reference/functions/do_settings_fields/  -->
    <h3>Render HTML content of the setting fields for a specific section - at a particular page</h3>
    <?php do_settings_fields( $fieldData['page'], $fieldData['section'] ); ?>

    <!-- 4. Output a HTML data for the submit button -->
    <?php submit_button( 'Save your changes' , 'primary' , 'custom-submit-button' ); ?> 
</form>


