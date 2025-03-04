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

abstract class AbstractAdminPage extends BaseController{

    /** 1. Variable decalration */
    // 1. Callback function to render HTML content
    public DisplayWpAdminPages $displayCallbacks;

    // 2. styles and script - must defined in detail 
    // const STYLE_FILENAME = 'admin-parent-root.css';
    // const STYLE_HANDLER = 'dutapod-admin-parent-root-style';
    // const SCRIPT_FIlENAME = 'admin-parent-root.js';
    // const SCRIPT_HANDLER = 'dutapod-admin-parent-root-script';

    // Need to declare $STYLE_PATH and $SCRIPT_PATH in the child class. These variables are customized basing on each specific class.
    // public static $STYLE_PATH;
    // public static $SCRIPT_PATH;

    // 3. WP admin setting pages properties
    // 3.1. WP admin parent root page properties
    public string $page_title; // i.e: Dutapod Plugin
    public string $menu_title; // i.e: Dutapod Companion
    public string $capability; // i.e: manage_options
    public string $menu_slug;  // i.e: dutapod-companion_plugin (plugin name is : dutapod-companion)
    // Callback function to display HTML content at WP admin setting page
    // public $callback; $this->renderPageContent() has already fulfilled this task
    public string $icon_url;  // i.e: dashicons-welcome-widgets-menus // use built-in icon of WordPress
    public int $page_position; // 'position' argument when adding page to WP admin setting page. 112 is the default last most

    // Priority for adding menu/submenu page to the WP admin setting page. Default = 10
    public int $admin_menu_priority;

    // public static string $MENU_SLUG;

    // 3.2. Sections properties

    // 3.3. Fields properties
    

    /** 2. Constructor */
    // 2.1. Main constructor
    // 2.1.1. Simple constructor withour variable
    public function __construct(){
        // 1. Initialize parent constructor
        parent::__construct();

        // 2. Initialize the display callback 
        $this->displayCallbacks = DisplayWpAdminPages::getInstance();

        // 3. Initialize default value that will not be change across inherited class:
        $this->admin_menu_priority = 10;
        // 3. Setup additional class local properties
        // $this->set_Local_Class_Properties();

        // 4. Load extra resources if requesting to this WP admin parent root page
        // $this->load_Extra_Resources();
    }//__construct

    // 2.1.2. Constructor with variable parsing
    public static function createPageWithInputPageData( array $inputPageData ){}
    
    /** 2.2. Helper method for constructor*/
    /** 2.2.1. Set local properties for this local class */
    public function set_Local_Class_Properties(){}//set_Local_Properties

    /** 3. Main operational function */ 
    /** 3.1.1. Register service to plugin workflow*/
    public function register(){}//register    
    
    /** 3.1.2. Render page content */
    public function renderPageContent(){}//renderPageContent    

    /** 3.2. Register & enqueue extra resources (style, script) */
    /** 3.2.1. Load extra resources if accessing this page */
    public function load_Extra_Resources(){}//load_Extra_Resources

    /** 3.2.2. Register extra resources for this admin parent root page */
    public function register_Extra_Resources(){}//register_Extra_Resources

    /** 3.2.3. Enqueue extra resources for this admin parent root page */
    public function enqueue_Extra_Resources(){}//enqueue_Extra_Resources

}//AbstractAdminPage class definition