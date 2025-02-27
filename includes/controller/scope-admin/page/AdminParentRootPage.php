<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace  DutapodCompanion\Includes\Controller\ScopeAdmin\Page;

// 1. Debug information
// Init class object
use DutapodCompanion\Includes\Init as Init;
// Plugin system variables
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
// Debug helper class
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

// 2. WP admin setting page information
// use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\SettingsManagerPage as SettingsManagerPage;
use DutapodCompanion\Includes\Api\Callbacks\Admin\DisplayWpAdminPages as DisplayWpAdminPages;
use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\AbstractAdminPage as AbstractAdminPage;
// use DutapodCompanion\Includes\Base\BaseController as BaseController;

/** Support the display and operational function of the admin's parent root page 
 * 1. Enqueue custom CSS and JS - OK.
 * 2. Display the content of this page at its corresponding WP admin setting pages - OK
 * 3. Handle AJAX request if it is exist.
*/

class AdminParentRootPage extends AbstractAdminPage{

    /** 1. Variable decalration */
    // 1. Callback function to render HTML content - defined in AbstractPage class

    // 2. styles and script
    const STYLE_FILENAME = 'admin-parent-root.css';
    const STYLE_HANDLER = 'dutapod-admin-parent-root-style';
    const SCRIPT_FIlENAME = 'admin-parent-root.js';
    const SCRIPT_HANDLER = 'dutapod-admin-parent-root-script';

    // 2.2. Define style and script path - defined in AbstractPage class
    // public static $STYLE_PATH;
    // public static $SCRIPT_PATH;

    // 3. WP admin setting pages properties - defined in the AbstractPage class
    // + menu_slug is dutapod-companion_plugin
    // + page_position is the original position

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

        // 4. Load extra resources if requesting to this WP admin parent root page
        // $this->load_Extra_Resources();
    }//__construct

    // 2.1.2. Constructor with variable parsing 
    public static function createPageWithInputData( array $inputData ){
        $currentPage = new self();

        $currentPage->page_title = $inputData['page_title'] ?? '';
        $currentPage->menu_title = $inputData['menu_title'] ?? '';
        $currentPage->capability = $inputData['capability'] ?? '';
        $currentPage->menu_slug = $inputData['menu_slug'] ?? '';
        // self::$MENU_SLUG = $inputData['menu_slug'] ?? '';
        $currentPage->icon_url = $inputData['icon_url'] ?? '';

        // $currentPage->callback = $inputData['callback'] ?? (function(){ return false; })();

        $currentPage->page_position = $inputData['page_position'] ?? 0;

        return $currentPage;
    }//createPageWithFullData


    /** 2.2. Helper method for constructor*/
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
    }//set_Local_Properties

    /** 3. Main operational function */ 
    /** 3.1.1. Register service to plugin workflow*/
    public function register(){
        $this->load_Extra_Resources();
    }//register

    /** 3.1.2. Render page content */
    public function renderPageContent(){
        $this->displayCallbacks = $this->displayCallbacks ?? DisplayWpAdminPages::getInstance();

        $this->displayCallbacks->renderAdminParentRootPage();
    }//renderPageContent

    /** 3.2. Register & enqueue extra resources (style, script) */
    /** 3.2.1. Load extra resources if accessing this page */
    public function load_Extra_Resources(){
        // 1. Validate the client's incoming request.
        // 1.1. If requesting to an admin page
        if( !is_admin() ) return false;// OK

        // 1.2. If request to admin.php
        global $pagenow;
        if( 'admin.php' !== $pagenow ) return false;//OK  

        $requestPageSlug = $_GET['page'];     

        // 1.3. If in the right array list
        // if( !in_array( $requestPageSlug, self::$ADMIN_PAGES)  ) return false;     

        // 1.4. If not requesting the dutapod-companion_plugin admin setting page
        if( is_null( $requestPageSlug ) || $this->menu_slug !== $requestPageSlug ) return false;

        // 2. Enqueue extra resource if correctly requesting to the WordPress admin setting page
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_Extra_Prerequisite_Resources'] );
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_Extra_Resources'] );
    }//load_Extra_Resources

    /** 3.2.2. Register extra resources for this admin parent root page */
    public function register_Extra_Resources(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$STYLE_PATH ) ? filemtime( self::$STYLE_PATH ) : false;
        wp_register_style( self::STYLE_HANDLER, self::$STYLE_PATH, [], $css_version, 'all' );

        /** 2.2. Enqueue the custom scripts */
        $js_version = file_exists( self::$SCRIPT_PATH ) ? filemtime( self::$SCRIPT_PATH ) : false;
        wp_register_script( self::SCRIPT_HANDLER, self::$SCRIPT_PATH, [], $js_version, true );

    }//register_Extra_Resources

    /** 3.2.3. Enqueue extra resources for this admin parent root page */
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

}//AdminParentRoot class definition
