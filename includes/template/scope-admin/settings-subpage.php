<h1>Manage all of the plugin settings</h1>

<!-- Display if there is any error after submitting the form. -->
<!-- Obtain the "SettingsSubpage class properties from $settingsSubpage variable -->
<?php 
// 1. Extract data from $settingSubpage

/** Validate $settingsSubpage - OK */

// 1.1. All setting data
// Settings data
$settingData = $settingsSubpage->settingsData[0];
// $optionGroup = $settingData['option_group'];
// $optionName = $settingData['option_name'];

// Section data
$sectionData = $settingsSubpage->sectionsData[0];
// $sectionID = $sectionData['id'];

$fieldData = $settingsSubpage->fieldsData[0];

// 1.2. The plugin's general settings data (settings, sections, fields)
// $settingsSubpage->pluginSettingsData : An array of the plugin settings 's settings data 
$pluginSettingsData = $settingsSubpage->pluginSettingsData[0]; 
// $settingsSubpage->pluginSectionsData : An array of the plugin settings' section data
$pluginSectionsData = $settingsSubpage->pluginSectionsData[0]; 
// $settingsSubpage->pluginSectionsFieldsData : An array of the plugin settings' section fields data
$pluginSectionsFieldsData = $settingsSubpage->pluginSectionsFieldsData[0];

?>

<?php settings_errors(); ?>

<?php // var_dump( $fieldData );
/** 1. Create 3 plugin properties, save it in the wp_options table: 
 * option_name: <plugin_name>_property_1 ; option_value: <plugin_name>_property_1_value
 * ... 
*/
?>

<!-- 1. Form that manage Wordpress settings, sections, and fields for the current submenu "settings page" -->
<!-- 1.1. Form to manage all plugin's settings -->
<!-- 
<form method="post" action="options.php" class="dutapod-companion-general-form">
    <?php // settings_fields(  $settingData[ 'option_group' ] ); ?>
    <?php // do_settings_sections(  $settingsSubpage->menu_slug ); ?> 
    <?php // submit_button( 'Save your changes' , 'primary' , 'custom-submit-button' ); ?> 
</form>
-->

<!-- 1.2. Form to manage plugin general settings 's settings -->
<!-- Setting API documentation: https://developer.wordpress.org/plugins/settings/settings-api/  -->
<h2>Form for managing all the plugin's general settings</h3>
<form method="post" action="options.php" class="dutapod-companion-plugin-settings-form" id="pluggin-settings-form-id">
    <!-- 1. Specify setting groups. This will include a hidden form -->
    <!-- This function will generate reference to the custom admin page -->
    <!-- Relevant API documentation: https://developer.wordpress.org/reference/functions/settings_fields/  -->
    <h3>1. Render HTML content for Settings fields</h3>
    <?php settings_fields(  $pluginSettingsData[ 'option_group' ] ); ?>

    <!-- 2. Implement the settings for a specific page - using slug -->
    <!-- Using the value menu_slug of the troubleshoot page -->
    <!-- Relevant API documentation: https://developer.wordpress.org/reference/functions/do_settings_sections/ -->
    <h3>2. Render HTML content of the setting section for a specific page</h3>
    <?php do_settings_sections(  $settingsSubpage->menu_slug ); ?> 

    <!-- 3. Render the settings field registered at the specific section of the specific page -->
    <!-- Relevant API documentation: https://developer.wordpress.org/reference/functions/do_settings_fields/  -->
    <!-- 
        <h3>Render HTML content of the setting fields for a specific section - at a particular page</h3>
        <?php //do_settings_fields( $fieldData['page'], $fieldData['section'] ); ?>
    -->

    <!-- 4. Output a HTML data for the submit button -->
    <?php submit_button( 'Save your changes' , 'primary' , 'dutapod-plugin-setings submit-button' ); ?> 
</form>



