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

class SettingsSubpage extends AbstractAdminSubpage{

    /** I. Variable decalration */
    // 1. Callback function to render HTML content - defined in AbstractSubpage class


    // 2. styles and script
    const STYLE_FILENAME = 'settings-subpage.css';
    const STYLE_HANDLER = 'dutapod-settings-subpage-style';
    const SCRIPT_FIlENAME = 'settings-subpage.js';
    const SCRIPT_HANDLER = 'dutapod-settings-subpage-script';

    // 2.2. Public path of styles and scripts - defined in AbstractSubpage class
    // public static $STYLE_PATH;
    // public static $SCRIPT_PATH;

    // 3. WP admin setting pages properties - defined in AbstractSubpage class
    // 3.1. WP admin subpage properties
    // + menu_slug is dutapod-companion_plugin_troubleshoot
    // + page_position is the original position    

    // 3.1.2. Extra properties
    public string $pageId;
    public string $pageTitle;
    public string $pageClassnames;

    // 3.2. Settings properties - stored in 'wp_options' table
    public string $option_group;
    public string $option_name;
    // public $callbacks; 

    public array $settingsData;

    // 3.3. Sections properties
    public array $sectionsData;

    // 3.4. Fields properties
    public array $fieldsData;  

    /** II. Constructor */
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

        $this->set_Subpage_Properties();

        // 4. Load extra resources if requesting to this WP admin troubleshooting page
        // $this->load_Extra_Resources();
    }//__construct

    // 2.1.2. Constructor with variable parsing
    public static function createPageWithInputSubpageData( array $inputSubpageData ){
        $currentPage = new self();

        $currentPage->parent_slug = $inputSubpageData['parent_slug'] ?? '';
        $currentPage->page_title = $inputSubpageData['page_title'] ?? '';
        $currentPage->menu_title = $inputSubpageData['menu_title'] ?? '';
        $currentPage->capability = $inputSubpageData['capability'] ?? '';
        $currentPage->menu_slug = $inputSubpageData['menu_slug'] ?? '';        
        //self::$MENU_SLUG = $inputData['menu_slug'] ?? '';
        // $currentPage->callback = $inputData['callback'] ?? (function(){ return false; })();
        $currentPage->icon_url = $inputSubpageData['icon_url'] ?? '';
        $currentPage->subpage_position = $inputSubpageData['subpage_position'] ?? 0;

        // admin menu priority 
        $currentPage->admin_menu_priority = $inputSubpageData['admin_menu_priority'] ?? $currentPage->admin_menu_priority;

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
        $this->pageClassnames = 'dutapod-settings';
    }//set_Subpage_Properties

    /** 2.2.2.2. settings data - without array $inputData */
    public function set_Settings_Data(){
        // 'callback'          => array( $this->callbacksManager, 'checkboxSanitize' ),
        $this->option_name = sprintf( '%s_plugin_settings', self::$PLUGIN_NAME);
        $this->option_group = sprintf( '%s_plugin', self::$PLUGIN_NAME );

        $settingDataItem = [
            'option_group'  =>  $this->option_name,
            'option_name'   => $this->option_group,
            'callback'      => [$this, 'checkboxSanitize'],
        ]; 

        $this->settingsData[] = $settingDataItem;
    }//set_Settings_Data

    /** 2.2.2.3. sections data */
    public function set_Sections_Data( array $inputData ){
        // 'callback'      => array( $this->callbacksManager, 'dutapodSectionManager' ),
        $sectionDataItem = [
            'id'            => sprintf( '%s_demo_section', self::$PLUGIN_NAME ),
            'title'         => $this->page_title,
            'callback'      => [ $this, 'renderDemoSectionContent' ],
            'page'          => $this->menu_slug,
        ];

        $this->sectionsData[] = $sectionDataItem;
    }//set_Sections_Data

    /** 2.2.2.4. fields data */
    public function set_Fields_Data( array $inputData ){

        // 'callback'      => array($this->callbacksManager, 'displayCheckboxField'),
        $fieldDataItem = [
            'id'            => $this->pageId,
            'title'         => sprintf('Activate %s', $this->pageTitle),  
            'callback'      => [ $this, 'displayCheckboxField' ],          
            'page'          => $this->menu_slug,
            'section'       => sprintf( '%s_demo_section', self::$PLUGIN_NAME ),
            'args'          => array(
                'option_name'   => $this->option_name,
                'label_for'     => $this->pageId,
                'class'         => sprintf('ui-toggle %s', $this->pageClassnames),
            )
        ];

        $this->fieldsData[] = $fieldDataItem;

    }//set_Fields_Data

    /** III. Main operational function */
    /** 3.1.1. Register service to plugin workflow*/
    public function register(){
        // 1. Add this top-level admin setting page to the WP admin menu page
        
        // Must be after the top-level admin menu page
        add_action( 'admin_menu', [ $this, 'add_SubMenu_Page_To_WP_Admin_Menu' ], $this->admin_menu_priority );

        // 2. Load extra resources for this top level page
        $this->load_Extra_Resources();        

        // 3. Add settings for the admin parent root page

        // 4. Add sections for the admin parent root page

        // 5. Add fields for the admin parent root page

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

        $this->localDebugger->write_log_general( $page );

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

    /** 4. Helper methods */
    /** 4.1. Render page content */
    public function renderPageContent(){
        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/settings-subpage.php" );
    }//renderTroubleshootSubpageContent

    /** 4.2. Settings callback -  Checkbox sanitize */
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

    // 4.3. Section callback - Render demo section content
    public function renderDemoSectionContent(){
        echo '<h1>Manage the sections & features of the dutapod-companion plugin</h1>';
    }//renderDemoSectionContent

    // 4.4. Field callback - Display checkbox field 
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


}//SettingsSubpage class definition