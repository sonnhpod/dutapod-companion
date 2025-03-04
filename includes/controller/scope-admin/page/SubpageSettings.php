<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace  DutapodCompanion\Includes\Controller\ScopeAdmin\Page;

// Init class object
use DutapodCompanion\Includes\Init as Init;
// Plugin system variables
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
// Debug helper class
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\SettingsManagerPage as SettingsManagerPage;
use DutapodCompanion\Includes\Api\Callbacks\Admin\DisplayWpAdminPages as DisplayWpAdminPages;
use DutapodCompanion\Includes\Base\BaseController as BaseController;
use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\AbstractAdminSubpage as AbstractAdminSubpage;

class SubpageSettings extends AbstractAdminSubpage{

    /** 1. Variable decalration */
    // 1. Callback function to render HTML content - defined in AbstractSubpage class

    // 2. styles and script
    const STYLE_FILENAME = 'settings-subpage.css';
    const STYLE_HANDLER = 'dutapod-settings-subpage-style';
    const SCRIPT_FIlENAME = 'settings-subpage.js';
    const SCRIPT_HANDLER = 'dutapod-settings-subpage-script';

    // 2.2. Public path of styles and scripts - defined in AbstractSubpage class
    public static $STYLE_PATH;
    public static $SCRIPT_PATH;

    // 3. WP admin setting pages properties - defined in AbstractSubpage class
    // 3.1. WP admin subpage properties
    // + menu_slug is dutapod-companion_plugin_troubleshoot
    // + page_position is the original position    

    // 3.1.2. Extra properties
    public string $pageId;
    public string $pageTitle;
    public string $pageClassnames;

    // 3.2. Settings properties - stored in 'wp_options' table
    // 3.2.1. General settings
    public string $option_group;
    public string $option_name;

    // 3.2.2. Plugin settings group
    public string $settings_Option_Name;
    public string $settings_Option_Group;

    // public $callbacks; 
    // Settings Data can be used across submenu page's sections
    public array $settingsData;
    // 3.2.2. Settings data for the plugin's general settings
    public array $pluginSettingsData;
    public string $pluginSettingsSectionID;

    // 3.3. Sections properties
    public array $sectionsData;
    // 3.3.1. Demo section 
    public array $demoSection;
    // 3.3.2. General settings section data
    // public array $generalSettingsSection;
    public array $pluginSettingsSectionsData;

    // 3.4. Fields properties
    public array $fieldsData;  
    // 3.4.1. Fields for Demo section 
    public array $demoSectionFields;
    // 3.4.2. General settings section data
    public array $pluginSettingsSectionFieldsData;

    /************************************************************************************************************/
    /** 2. Constructor */
    // 2.1. Main constructor
    // 2.1.1. Simple constructor withour variable
    public function __construct(){
        // 1. Initialize parent constructor
        parent::__construct();
        
        // 2. Initialize the display callback 
        // $this->displayCallbacks = DisplayWpAdminPages::getInstance();

        // 3. Setup additional class local properties
        $this->set_Local_Class_Properties();

        // $this->set_Subpage_Properties();
       

        // 4. Load extra resources if requesting to this WP admin troubleshooting page
        // $this->load_Extra_Resources();
    }//__construct

    // 2.1.2. Constructor with variable parsing
    public static function createPageWithInputSubpageData( array $inputSubpageData ){
        $currentPage = new self();

        // 1. Page properties
        $currentPage->parent_slug = $inputSubpageData['parent_slug'] ?? '';
        $currentPage->page_title = $inputSubpageData['page_title'] ?? '';
        $currentPage->menu_title = $inputSubpageData['menu_title'] ?? '';
        $currentPage->capability = $inputSubpageData['capability'] ?? '';
        $currentPage->menu_slug = $inputSubpageData['menu_slug'] ?? '';        

        $currentPage->icon_url = $inputSubpageData['icon_url'] ?? '';
        $currentPage->subpage_position = $inputSubpageData['subpage_position'] ?? 0;

        // admin menu priority 
        $currentPage->admin_menu_priority = $inputSubpageData['admin_menu_priority'] ?? $currentPage->admin_menu_priority;

        $currentPage->set_Subpage_Properties();

        // 2. Settings properties 
        $currentPage->set_Settings_Data();

        // 3. Section properties
        $currentPage->set_Sections_Data();

        // 4. Field properties
        $currentPage->set_Fields_Data();

        return $currentPage;
    }//createPageWithFullData

    /** 2.2. Helper method for constructor */
    /** 2.2.1. Set local properties for this local class */
    public function set_Local_Class_Properties(){
        /** 1. Set the resources information for WordPress front page */
        self::$STYLE_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_ADMIN_ROOT_DIR,
            PluginProperties::CSS_ROOT_DIR.'page/', 
            self::STYLE_FILENAME
        );

        self::$SCRIPT_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_ADMIN_ROOT_DIR,
            PluginProperties::JS_ROOT_DIR.'page/', 
            self::SCRIPT_FIlENAME
        );

        /** 2. Page content properties */
        $this->settingsData = [];
        $this->sectionsData = [];
        $this->fieldsData = [];
    }//set_Local_Properties

    /** 2.2.2. Page content properties */
    /** 2.2.2.1. Subpage data */
    public function set_Subpage_Properties(){
        $this->pageId = 'settings';
        $this->pageTitle = 'Settings Page';
        $this->pageClassnames = 'dutapod-page-general-settings';
    }//set_Subpage_Properties

    /** 2.2.2.2. settings data - without array $inputData */
    public function set_Settings_Data(){
        // 'callback'          => array( $this->callbacksManager, 'checkboxSanitize' ),
        $this->option_name = sprintf( '%s_plugin_settings', self::$PLUGIN_NAME);
        $this->option_group = sprintf( '%s_plugin', self::$PLUGIN_NAME );

        // 1. General setting data
        $settingArgs = [
            'type'          => 'string',
            'label'         => 'dutapod-companion_plugin_label',
            'description'   => 'general setting for option name: "dutapod-companion_plugin_settings", option group: "dutapod-companion_plugin"',
            'default'       => 'dutapod-companion_plugin default value'
        ];

        $settingDataItem = [
            'option_group'  => $this->option_group,
            'option_name'   => $this->option_name,
            'callback'      => [$this, 'checkboxSanitize'],
            'args'          => $settingArgs,
        ]; 

        $this->settingsData[] = $settingDataItem;

        // 2. Settings data for the plugin's general setting
        // 2.1. Settings data for author name property
        $option_name = sprintf( '%s_author_name', self::$PLUGIN_NAME );
        $this->settings_Option_Group = sprintf( '%s_plugin_settings_group', self::$PLUGIN_NAME );

        $settingArgs = [
            'type'              => 'string',
            'label'             => 'dutapod-companion_plugin_author_name_label',
            'description'       => 'Setting for the option_name: "dutapod-companion_author_name", option group: "dutapod-companion_plugin_settings_group"',
            'sanitize_callback' => [$this, 'sanitize_Input_Text_Field'],
            'default'           => 'dutapod-companion_author_name default value'
        ];

        $settingDataItem = [
            'option_group'  => $this->settings_Option_Group,
            'option_name'   => $option_name,
            'callback'      => [$this, 'checkboxSanitize'],
            'args'          => $settingArgs,
        ]; 

        $this->settingsData[] = $settingDataItem;
        $this->pluginSettingsData[] = $settingDataItem;

        // 2.2. Settings data for author email property
        $option_name = sprintf( '%s_author_email', self::$PLUGIN_NAME );

        $settingArgs = [
            'type'              => 'string',
            'label'             => 'dutapod-companion_plugin_author_email_label',
            'description'       => 'Setting for the option_name: "dutapod-companion_author_email", option group: "dutapod-companion_plugin_settings_group"',
            'sanitize_callback' => [$this, 'sanitize_Input_Email_Field'],
            'default'           => 'dutapod-companion_author_email default value'
        ];

        $settingDataItem = [
            'option_group'  => $this->settings_Option_Group,
            'option_name'   => $option_name,
            'callback'      => [$this, 'checkboxSanitize'],
            'args'          => $settingArgs,
        ]; 

        $this->settingsData[] = $settingDataItem;
        $this->pluginSettingsData[] = $settingDataItem;

        // 2.3. Settings data for author job title property
        $option_name = sprintf( '%s_author_job_title', self::$PLUGIN_NAME );
        $settingArgs = [
            'type'              => 'string',
            'label'             => 'dutapod-companion_plugin_author_job_title_label',
            'description'       => 'Setting for the option_name: "dutapod-companion_author_job_title", option group: "dutapod-companion_plugin_settings_group"',
            'sanitize_callback' => [$this, 'sanitize_Input_Text_Field'],
            'default'           => 'dutapod-companion_author_job_title default value'
        ];

        $settingDataItem = [
            'option_group'  => $this->settings_Option_Group,
            'option_name'   => $option_name,
            'callback'      => [$this, 'checkboxSanitize'],
            'args'          => $settingArgs,
        ]; 

        $this->settingsData[] = $settingDataItem;
        $this->pluginSettingsData[] = $settingDataItem;
    }//set_Settings_Data

    /** 2.2.2.3. sections data */
    public function set_Sections_Data(){
        // 1.1. General Demo Section 
        // 'callback'      => array( $this->callbacksManager, 'dutapodSectionManager' ),
        $sectionID = sprintf( '%s_demo_section', self::$PLUGIN_NAME );

        $sectionArgs = [
            'section_class'     => 'dutapod-companion-section-container demo'
        ];

        $this->demoSection = [
            'id'            => $sectionID,
            'title'         => $this->page_title,
            'callback'      => [ $this, 'renderDemoSectionContent' ],
            'page'          => $this->menu_slug,
            'args'          => $sectionArgs
        ];

        $this->sectionsData[] = $this->demoSection;

        // 1.2. General plugin settings section
        $this->pluginSettingsSectionID = sprintf( '%s_general_settings_section', self::$PLUGIN_NAME );
        // $sectionID = sprintf( '%s_general_settings_section', self::$PLUGIN_NAME );

        $sectionArgs = [
            'section_class'     => 'dutapod-companion-section-container general-settings'
        ];

        // 'id'            => $sectionID,
        $pluginSettingsSection = [
            'id'            => $this->pluginSettingsSectionID,
            'title'         => $this->page_title,
            'callback'      => [ $this, 'render_General_Settings_Section' ],
            'page'          => $this->menu_slug,
            'args'          => $sectionArgs
        ];

        $this->sectionsData[] = $pluginSettingsSection;
        $this->pluginSettingsSectionsData[ $this->pluginSettingsSectionID ] = $pluginSettingsSection;
    }//set_Sections_Data

    /** 2.2.2.4. fields data. There would be multiple fields for a single section 
     *  $this->fieldsData : manage all fields 
     *  $this->demoSectionFields: manage fields for demo sections
     *  $this->pluginSettingsSectionFieldsData: manage fields for the plugin settings section
    */
    public function set_Fields_Data(){
        // 1. Fields of demo section
        // 'callback'      => array($this->callbacksManager, 'displayCheckboxField'),
        // 'section'       => sprintf( '%s_demo_section', self::$PLUGIN_NAME )
        $fieldDataItem = [
            'id'            => $this->pageId,
            'title'         => sprintf('Activate %s', $this->pageTitle),  
            'callback'      => [ $this, 'displayCheckboxField' ],          
            'page'          => $this->menu_slug,
            'section'       => $this->demoSection['id'],
            'args'          => array(
                'option_name'   => $this->option_name,
                'label_for'     => $this->pageId,
                'class'         => sprintf('ui-toggle %s', $this->pageClassnames),
            )
        ];

        $this->fieldsData[] = $fieldDataItem;
        $this->demoSectionFields[] = $fieldDataItem;

        // 2. Fields of general settings section
        $pluginSettingsSection = $this->pluginSettingsSectionsData[ $this->pluginSettingsSectionID ];

        // 2.1. Plugin property 1 - author name
        // 'args' 'class'         => sprintf('%s author-name', $this->pageClassnames),
        $fieldDataItem = [
            'id'            => 'author_name',
            'title'         => 'Author Name',  
            'callback'      => [ $this, 'render_Author_Name_Field' ],          
            'page'          => $this->menu_slug,
            'section'       => $pluginSettingsSection['id'],
            'args'          => array(
                'option_name'   => sprintf('%s_author_name', self::$PLUGIN_NAME),
                'label_for'     => 'author_name',
                'class'         => 'plugin-general-settings author-name'
            )
        ];

        $this->fieldsData[] = $fieldDataItem;
        $this->pluginSettingsSectionFieldsData[] = $fieldDataItem;

        // 2.2. Plugin property 2 - author email
        // 'args' 'class'         => sprintf('%s author-name', $this->pageClassnames),
        $fieldDataItem = [
            'id'            => 'author_email',
            'title'         => 'Author Email',  
            'callback'      => [ $this, 'render_Author_Email_Field' ],          
            'page'          => $this->menu_slug,
            'section'       => $pluginSettingsSection['id'],
            'args'          => array(
                'option_name'   => sprintf('%s_author_email', self::$PLUGIN_NAME),
                'label_for'     => 'author_email',
                'class'         => 'plugin-general-settings author-email'
            )
        ];

        $this->fieldsData[] = $fieldDataItem;
        $this->pluginSettingsSectionFieldsData[] = $fieldDataItem;

        // 2.3. Plugin property 3 - author job title
        // 'args' 'class'         => sprintf('%s author-name', $this->pageClassnames),
        $fieldDataItem = [
            'id'            => 'author_job_title',
            'title'         => 'Author Job Title',  
            'callback'      => [ $this, 'render_Author_Job_Title_Field' ],          
            'page'          => $this->menu_slug,
            'section'       => $pluginSettingsSection['id'],
            'args'          => array(
                'option_name'   => sprintf('%s_author_job_title', self::$PLUGIN_NAME),
                'label_for'     => 'author_job_title',
                'class'         => 'plugin-general-settings author-job-title'
            )
        ];

        $this->fieldsData[] = $fieldDataItem;
        $this->pluginSettingsSectionFieldsData[] = $fieldDataItem;

    }//set_Fields_Data

    /************************************************************************************************************/
    /** 3. Main operational function */
    /** 3.1.1. Register service to plugin workflow*/
    public function register(){
        // 1. Add this top-level admin setting page to the WP admin menu page
        
        // Must be after the top-level admin menu page
        add_action( 'admin_menu', [ $this, 'add_SubMenu_Page_To_WP_Admin_Menu' ], $this->admin_menu_priority );

        // 2. Load extra resources for this top level page
        $this->load_Extra_Resources();        

        /** 3. Register settings, sections, and fields for this settings page: 
         * - The admin_init hook is executed after admin_menu*/ 
        // add_action( 'admin_init', [ $this, 'register_Submenu_Page_All_Settings' ] );     
        // 3.2. Register this submenu page's for only the plugin's general settings section.
        add_action( 'admin_init', [ $this, 'register_Submenu_Page_Plugin_General_Settings' ] );    

    }//register

    /** 3.1.2. Render page content */
    /** 3.2. Add top-level admin setting page */
    public function add_SubMenu_Page_To_WP_Admin_Menu(){
        $page = [
            'parent_slug'       => $this->parent_slug,
            'page_title'        => $this->page_title,
            'menu_title'        => $this->menu_title,
            'capability'        => $this->capability,
            'menu_slug'         => $this->menu_slug,
            'callback'          => [ $this, 'renderPageContent' ]
        ];

        // $this->localDebugger->write_log_general( $page );

        add_submenu_page(
            $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'],
            $page['menu_slug'], $page['callback']
        );
    }//add_SubMenu_Page_To_WP_Admin_Menu
    
    /** 3.2. Register & enqueue extra resources (style, script) */
    /** 3.2.1. Load extra resources if accessing this page */
    public function load_Extra_Resources(){
        // 1. Validate the client's incoming request.
        // 1.1. If requesting to an admin page
        if( !is_admin() ) return false;// OK

        // 1.2. If request to admin.php
        global $pagenow;
        if( 'admin.php' !== $pagenow ) return false;//OK  
        // $this->localDebugger->write_log_general(  );

        $requestPageSlug = $_GET['page'];     

        // 1.3. If in the right array list
        // if( !in_array( $requestPageSlug, self::$ADMIN_PAGES)  ) return false;     

        // 1.4. If not requesting the dutapod-companion_plugin_troubleshoot admin setting page
        if( is_null( $requestPageSlug ) || $this->menu_slug !== $requestPageSlug ) return false;

        // 2. Enqueue extra resource if correctly requesting to the WordPress admin setting page
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_Extra_Prerequisite_Resources' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_Extra_Resources' ] );
    }//load_Extra_Resources

    /** 3.2.2. Register extra resources for this admin troubleshoot page */
    public function register_Extra_Resources(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$STYLE_PATH ) ? filemtime( self::$STYLE_PATH ) : false;
        wp_register_style( self::STYLE_HANDLER, self::$STYLE_PATH, [], $css_version, 'all' );

        /** 2.2. Enqueue the custom scripts */
        $js_version = file_exists( self::$SCRIPT_PATH ) ? filemtime( self::$SCRIPT_PATH ) : false;
        wp_register_script( self::SCRIPT_HANDLER, self::$SCRIPT_PATH, [], $js_version, true );

    }//register_Extra_Resources

    /** 3.2.3. Enqueue extra resources for this admin troubleshoot page */
    public function enqueue_Extra_Resources(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$STYLE_PATH ) ? filemtime( self::$STYLE_PATH ) : false;
        wp_enqueue_style( self::STYLE_HANDLER, self::$STYLE_PATH, [], $css_version, 'all' );

        /** 2.2. Enqueue the custom scripts */
        $js_version = file_exists( self::$SCRIPT_PATH ) ? filemtime( self::$SCRIPT_PATH ) : false;
        wp_enqueue_script( self::SCRIPT_HANDLER, self::$SCRIPT_PATH, [], $js_version, true );

        /**  2.2.2. Localize this additional front page script */
        // wp_localize_script( self::SCRIPT_HANDLER, 'woocommerce_params', [ 'ajax_url' => admin_url('admin-ajax.php') ] );
    }//enqueue_Extra_Resources

    /** 3.2.4. Enqueue prerequisite resources for this admin troubleshoot page */
    public function enqueue_Extra_Prerequisite_Resources(){
        // 1. Style 
        wp_enqueue_style( 'dashicons' );

        // 2. Scripts
        // Media library 
        wp_enqueue_script( 'media-upload' );

        // jquery library
        wp_enqueue_script( 'jquery' );
    }//enqueue_Extra_Prerequisite_Resources

    /** 3.3. Register settings, sections, fields for the wp admin submenu settings page * /
     
    /** 3.3.1. Register all available settings, sections, and fields 
     * 1. This will do:
     * - Register settings
     * - Add settings sections. 
     * - Add settings fields for each section.
     * 
     * 2 Variables of all settings, sections, and fields are obtained in the corresponding variable:
     * - Settings : array $this->settingsData.
     * - Sections : array $this->sectionsData.
     * - Fields : array $this->fieldsData.
    */
    public function register_Submenu_Page_All_Settings(){
        /** 3. Add settings for the admin parent root page
         * 3.1. Register necessary settings for this settings subpage under an option group
         * */ 
        /** Documentation: https://developer.wordpress.org/reference/functions/register_setting/  */
        $settingData = $this->settingsData[0];        
        register_setting( $settingData['option_group'], $settingData['option_name'], $settingData['args'] );

        /** 4. Add sections for the admin parent root page */ 
        /** Documentation: https://developer.wordpress.org/reference/functions/add_settings_section/  */
        /** 4.1. Demo section */
        foreach( $this->sectionsData as $sectionData ){
            add_settings_section( $sectionData['id'], $sectionData['title'], $sectionData['callback'], $sectionData['page'], $sectionData['args'] );
        }

        /** 4.2. Plugin general settings section */

        /** 5. Add fields for the admin parent root page */ 
        /** Documentation: https://developer.wordpress.org/reference/functions/add_settings_field/  */
        /** 5.1. Fields for the demo section */
        foreach( $this->fieldsData as $fieldData ){
            add_settings_field( $fieldData['id'], $fieldData['title'], $fieldData['callback'], $fieldData['page'], $fieldData['section'], $fieldData['args'] );
        }

        /** 5.2. Fields for the plugin's general section*/
    }//register_Submenu_Page_All_Settings

    /** 3.3.2. Register only the plugin's general settings properties:
     * 1. This will include 
     * - Register settings of the plugin's general setting.
     * - Add settings sections of the plugin's general setting.
     * - Add settings fields for the settings section of the plugin's general setting.
    */
    public function register_Submenu_Page_Plugin_General_Settings(){
        /** 3. Add settings for the admin parent root page
         * 3.1. Register necessary settings for this settings subpage under an option group
         * - Register 3 plugin general settings:
         * + Author name
         * + Author email
         * + Author job title
         * */ 
        /** Documentation: https://developer.wordpress.org/reference/functions/register_setting/  */
        // $settingData = $this->settingsData[0];        
        // register_setting( $settingData['option_group'], $settingData['option_name'], $settingData['args'] );
        foreach( $this->pluginSettingsData as $settingData ){
            register_setting( $settingData['option_group'], $settingData['option_name'], $settingData['args'] );
        }

        /** 4. Add sections for the admin parent root page */ 
        /** Documentation: https://developer.wordpress.org/reference/functions/add_settings_section/  */
        /** 4.1. Getting general settings section directly from the variable $this->generalSettingsSection */
        foreach( $this->pluginSettingsSectionsData as $sectionData ){
            add_settings_section( $sectionData['id'], $sectionData['title'], $sectionData['callback'], $sectionData['page'], $sectionData['args'] );
        }

        /** 4.2. Plugin general settings section */

        /** 5. Add fields for the admin parent root page */ 
        /** Documentation: https://developer.wordpress.org/reference/functions/add_settings_field/  */
        /** 5.1. Getting a list of field of the general settings section at $$this->generalSettingsSectionFields  */       
        foreach( $this->pluginSettingsSectionFieldsData as $fieldData ){
            add_settings_field( $fieldData['id'], $fieldData['title'], $fieldData['callback'], $fieldData['page'], $fieldData['section'], $fieldData['args'] );
        }

        /** 5.2. Fields for the plugin's general section*/
    }//register_Submenu_Page_Plugin_General_Settings



    /************************************************************************************************************/
    /** 4. Helper methods */
    /** 4.1. Render page content */
    public function renderPageContent(){
        /** 1. Prepare data to parse into the template. 
         * - The data category include:
         * + Page data
         * + Settings data
         * + Sections data
         * + Section Fields data
         * */       

        // 2. Parse directly $settingsPage object to the template
        $settingsSubpage = $this;

        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/settings-subpage.php" );
    }//renderTroubleshootSubpageContent

    /** 4.2. Settings callback -  Sanitization methods */
    /** 4.2.1. Sanitize checkbox*/
    /*Sample input:
    * Input:  ["cpt_manager"] => 1; ["taxonomies_manager"]=>1; ["gallery_manager"]=>1 ... (only item set before)
    * Output: All items with boolean. If isset => true; if not set => false
    * ["cpt_manager"]=> true ; ["taxonomies_manager"]=> false;  ["gallery_manager"]=> true ...
    */
    public function checkboxSanitize($input): array
    {
        // Validate whether the checkbox is checked or not: true or false
        // return filter_var($input, FILTER_SANITIZE_NUMBER_INT); // filter number
        //return isset($input);
        $output = array();

        foreach($this->settingPageManagers as $pageManager){
            $output[$pageManager->id] = isset($input[$pageManager->id]) ;
        }

        return $output;
    }//checkboxSanitize

    /** 4.2.2. Sanitize input text field */
    public function sanitize_Input_Text_Field( $input ){
        return sanitize_text_field( $input );
    }//sanitizeInputTextField

    public function sanitize_Input_Email_Field( $input ){
        $sanitizedEmail = sanitize_email( $input );

        $optionEmailName = sprintf( '%s_author_email', self::$PLUGIN_NAME );

        if( ! is_email( $sanitizedEmail ) ){
            add_settings_error( $optionEmailName, 'invalid_email', 'Invalid email format' );
            return '';
        }

        return $sanitizedEmail;        
    }//sanitize_Input_Email_Field

    // 4.3. Section callback - 
    // 4.3.1. Render demo section content
    public function renderDemoSectionContent(){
        echo '<h4>Section content header of the dutapod-companion plugin</h4>';
    }//renderDemoSectionContent

    // 4.3.2. Render general plugin settings section content
    public function render_General_Settings_Section(){        
        $htmlOutput = <<<HTML
            <h4>General plugin settings</h4>
            <p>This will display 3 example plugin properties. After specifying plugin properties and click "save", these properties are stored in wp_options table</p>
            <ol>
                <li>Author Name.</li>
                <li>Author email.</li>
                <li>Author job title.</li>
            </ol>
        HTML;

        echo $htmlOutput;
    }//renderGeneralSettingsSection

    // 4.4. Field callback - Display checkbox field 
    // 4.4.1. Fields for demo section 
    public function displayCheckboxField( $args ){
        $name = $args['label_for'];
        $classes = $args['class'];
        // $checkbox = get_option($name) ? 'checked' : ''; // OK
        //$option_name = get_option( $args['option_name'] ); // as tutorial ?
        $option_name = $args['option_name'];
        /* 1 - Array of items with key (string) - value (boolean)
         *  ["cpt_manager"]=> true ; ["taxonomies_manager"]=> false;  ["gallery_manager"]=> true
         ***/
        $checkboxDbValue = get_option( $option_name );
        // $checkboxDbStatus = isset($checkboxDbValue[$name]) ? ( $checkboxDbValue[$name] ? true : false ) : false;
        $checkboxDbStatus = isset($checkboxDbValue[$name]) && $checkboxDbValue[$name]; // Equivalent expression to the above
        $checkbox = $checkboxDbStatus ? 'checked' : '';
        //$checkbox = $checkboxDbValue[$name] ? 'checked' : ''; // OK
    
        $displayName = sprintf('%s[%s]',$option_name, $name); // display: devsunshine_plugin[cpt_manager]
        //$checkStatus = get_option($name) ? 'checked' : 'unchecked';

        $outputHTML =  <<<HTML
        <div class="{$classes}">
            <input type="checkbox" name="{$displayName}" value="1" class="{$classes}" $checkbox>
            <label class="item-checkbox-label" for="{$name}">
              <div></div>
            </label>
        </div>
        HTML;

        echo $outputHTML;    
    }//displayCheckboxField

    // 4.4.2. Fields for general plugin settings section
    // 4.4.2.1. callback function to display author name field
    public function render_Author_Name_Field( $args ){
        $this->display_Plugin_WP_Option_Entry( $args );
    }//render_Author_Name_Field

    // 4.4.2.2. callback function to display author email field
    public function render_Author_Email_Field( $args ){
        $this->display_Plugin_WP_Option_Entry( $args );
    }//render_Author_Email_Field

    // 4.4.2.3. callback function to display author job title field
    public function render_Author_Job_Title_Field( $args ){
        $this->display_Plugin_WP_Option_Entry( $args );
    }//render_Author_Job_Title_Field

    /************************************************************************************************************/
    /** 5. Helper methods for 4 - display HTML content */

    public function display_Plugin_WP_Option_Entry( $args ){
        $name = $args['label_for'];// use for id, name
        $nameID = "$name-id";
        $cssClasses = $args['class'];
        $option_name = $args['option_name'];

        $option_value = get_option( $option_name );

        $option_value = esc_attr( $option_value );
        //$pluginName = self::$PLUGIN_NAME;
        //$option_value = $option_value ?? '';

        // Display name for each field would be: author Name, author email, author job title
        // $displayName = sprintf('%s : ',$option_name, $name); // display: devsunshine_plugin[cpt_manager]

        // <input class="{$cssClasses}" type="hidden" name="{$displayName}" value="{$option_value}">
        // <label class="field-label author-name">{$displayName}</label>
        $outputHTML = <<<HTML
        <div class="{$cssClasses} {$name}-container">           
            <input type="text" id="{$nameID}" name="{$option_name}" class="field-value {$name}" value="{$option_value}">
        </div><!--.{$cssClasses}-->
        HTML;

        echo $outputHTML;
    }//display_Plugin_WP_Option_Entry


}//SubpageSettings class definition