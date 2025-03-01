<?php 
/*
 * @package dutapod-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Controller\ScopeAdmin;

use DutapodCompanion\Includes\Base\BaseController as BaseController;

// 2. WP admin setting pages - system variables 
use DutapodCompanion\Includes\Api\SettingsAdminPages as SettingsAdminPages;
// use SunsetPro\Includes\Api\Callbacks\Admin\AdminParentCallbacks as AdminParentCallbacks;
use DutapodCompanion\Includes\Api\Callbacks\Admin\DisplayWpAdminPages as DisplayWpAdminPages;
use DutapodCompanion\Includes\Api\Callbacks\Admin\AdminManagerCallbacks as AdminManagerCallbacks;
// 3. WP admin page system controller 
use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\PageAdminParentRoot as PageAdminParentRoot;
use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\SubpageSettings as SubpageSettings;
use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\SubpageTroubleshoot as SubpageTroubleshoot;

/** 1. This class is responsible to insert all plugins' admin setting pages to the WP admin setting pages menu. 
 * 2. Steps to insert WP admin setting pages of this plugin:
 * 2.1. Insert the top-level plugin admin setting page: menu_slug: dutapod-companion_plugin 
 * 2.2. Insert submenu admin setting pages (if it is activated):
 * - Submenu page custom content management. menu_slug: dutapod-companion_plugin-custom_content
 * - Submenu page custom post type management. menu_slug: dutapod-companion_plugin-custom_post_type
 * - Submenu page custom shortcode management. menu_slug: dutapod-companion_plugin-custom_shortcode
 * - Submenu page custom taxonomy management. menu_slug: dutapod-companion_plugin-custom_taxonomy
 * - Submenu page custom widget management. menu_slug: dutapod-companion_plugin-custom_widget
 * 2.3. Insert the submenu settings management page. menu_slug: dutapod-companion_plugin-settings_management
 * 2.4. Innsert the submenut troubleshoot page. menu_slug: dutapod-companion_plugin-troubleshoot
*/
/** - The original class is AdminGeneral / Admin in all previous plugin version */
class MenuAdminPages extends BaseController{

    /** 1. Variables declaration */
    // 1.1. WP admin setting page system variables
    public SettingsAdminPages $settings;
    // public SunsetproAdmin $callbacks;
    public DisplayWpAdminPages $displayCallbacks;
    public AdminManagerCallbacks $callbacksManager;

    // 1.2. WP admin setting page controller
    // Admin parent root page
    public PageAdminParentRoot $adminParentRootPage;
    public SubpageTroubleshoot $troubleshootSubpage;
    public SubpageSettings $settingsSubpage;
    // Troubleshoot page

    // An array that store a list of a parent admin setting page.
    public array $pages;   
    // Sub page corresponding with each parent page
    public array $subpages;

    public static array $MENU_PAGES;
    public static array $SUBMENU_PAGES;

    /** 2. Constructor */
    public function __construct(){
        parent::__construct();
    }//__construct  

    /** 2.2. Helper functions for constructor */

    /** 3. Main operational functions*/
    /** 3.1. Main register method - invoke in the main plugin execution file */
    public function register(){
        // 1. Initialize al necessary variables
        // 1.1. Initialize WP admin setting page system variables 
        $this->settings = new SettingsAdminPages();

        //$this->callbacks = new SunsetproAdmin();
        // $this->displayCallbacks = new DisplayWpAdminPages();// Move display callback handler to each corresponding Page Controller class
        $this->callbacksManager = new AdminManagerCallbacks();

        // 1.2. Initialize WP admin setting pages controller:
        // 1.2.1. Initialize an admin parent root page instance.
        // a.
        // - Use wrapped constructor. 
        // + menu_slug is dutapod-companion_plugin
        // + page_position is the original position
        $this->adminParentRootPage = PageAdminParentRoot::createPageWithInputPageData(
            [
                'page_title'            => 'Dutapod Plugin',
                'menu_title'            => 'Dutapod Companion',
                'capability'            => 'manage_options',
                'menu_slug'             => sprintf( '%s_plugin', self::$PLUGIN_NAME ),               
                'icon_url'              => 'dashicons-welcome-widgets-menus',
                'page_position'         => 121,
                'admin_menu_priority'   => 120,
            ]
        );

        /** b. Register the admin parent root page instance to the plugin's workflow.
         * - Add this top-level menu page to the WP admin menu page 
         * - Load its corresponding custom CSS and JS 
         * */         
        $this->adminParentRootPage->register();

        // c. Add to the class's static property for management purpose
        self::$MENU_PAGES[ $this->adminParentRootPage->menu_slug ] = $this->adminParentRootPage;

        // 1.2.2. troubleshoot submenu page
        // a. Create a troubleshoot submenu page - Use wrapped constructor.  
        // + parent_slug is dutapod-companion_plugin       
        $this->troubleshootSubpage = SubpageTroubleshoot::createPageWithInputSubpageData(
            [
                'parent_slug'           => sprintf( '%s_plugin', self::$PLUGIN_NAME ),
                'page_title'            => 'Dutapod troubleshoot page',
                'menu_title'            => 'Troubleshoot',
                'capability'            => 'manage_options',
                'menu_slug'             => sprintf( '%s_plugin-troubleshoot', self::$PLUGIN_NAME ),     
                'subpage_position'      => 10,    
                'admin_menu_priority'   => $this->adminParentRootPage->admin_menu_priority + 8,       
            ]
        );

        // b. Register the admin parent root page instance to the plugin's workflow
        $this->troubleshootSubpage->register();

        // c. Add to the class's static property for management purpose
        self::$SUBMENU_PAGES[ $this->troubleshootSubpage->menu_slug ] = $this->troubleshootSubpage;

        // 1.2.3. Settings Management subpage
        $this->settingsSubpage = SubpageSettings::createPageWithInputSubpageData(
            [
                'parent_slug'           => sprintf( '%s_plugin', self::$PLUGIN_NAME ),
                'page_title'            => 'Dutapod Settings Management page',
                'menu_title'            => 'Settings',
                'capability'            => 'manage_options',
                'menu_slug'             => sprintf( '%s_plugin-settings', self::$PLUGIN_NAME ),     
                'subpage_position'      => 2,    
                'admin_menu_priority'   => $this->adminParentRootPage->admin_menu_priority + 2,       
            ]
        );

        // Register the admin parent root page instance to the plugin's workflow
        $this->settingsSubpage->register(); // Cause error when registering settings subpage

        // c. Add to the class's static property for management purpose
        self::$SUBMENU_PAGES[ $this->settingsSubpage->menu_slug ] = $this->settingsSubpage;

        /** 1.3. Register all WP admin setting page object to the WP workflow 
         * - Register at admin_init hook
        */

        // add_action( 'admin_init', [ $this->adminParentRootPage, 'register' ], 201 );
        // add_action( 'admin_init', [ $this->settingsSubpage, 'register' ], 202 );
        // add_action( 'admin_init', [ $this->troubleshootSubpage, 'register' ], 203 );


        // 2. Set WP admin setting page list
        // 2.1. WP admin setting pages
        $this->setPages();
        // 2.2. WP admin setting sub-pages
        $this->setSubpages();

        // 3. Setup properties for $this->settings (settings, sections, fields)
        // 2025-02-28 : disable these options. Assign settings, sectiosn, fields for each menu/submenu page object
        //$this->setSettings();
        //$this->setSections();
        //$this->setFields();

        // 4. Register admin setting pages from plugin
        // - "Control Dashboard" is the original value of withSubPage method
        /**
         * - Add the parent admin page
         * - Add the 1st sub page named 'overview' with the same properties as parent admin setting page 
         * (parent_slug, page_title, menu_title, capability, menu_slug ) Only different display callback function
         * 
        */
        // $this->settings->addAdminPages( $this->pages )->withSubPage( 'Overview' )->addSubPages( $this->subpages )->register();
    }//register

    /* === Register the main pages in WordPress Admin setting pages === */
    public function setPages(){
        // 1. Admin parent root page of this plugin - Dutapod
        // - Original callback entry: 'callback'      => array($this->displayCallbacks, 'renderAdminParentRootPage'),
        // - Original menu_slug entry: 'dutapod_plugin'

        $this->pages = [
            [
                'page_title'    => $this->adminParentRootPage->page_title,
                'menu_title'    => $this->adminParentRootPage->menu_title,
                'capability'    => $this->adminParentRootPage->capability,
                'menu_slug'     => $this->adminParentRootPage->menu_slug,
                'callback'      => [ $this->adminParentRootPage, 'renderPageContent' ],
                'icon_url'      => $this->adminParentRootPage->icon_url,
                'position'      => $this->adminParentRootPage->page_position,
            ]
        ];
    }//setPages

    /* === Register the sub pages === */
    // 20250226 - original troubleshoot page
    /*  public function setSubpages(){
        // UI frontend display of the Sunset carousel
        $customCarouselPage = array(
            'parent_slug'           => 'dutapod_plugin',
            'page_title'            => 'Dutapod Custom Carousel (UI frontend of Custom Post Types CPT)',
            'menu_title'            => 'Carousel',
            'capability'            => 'manage_options',
            'menu_slug'             => 'dutapod_plugin_carousel',
            'callback'              => array($this->callbacks, 'renderAdminCarouselPage')
        );
        
        // Manage Sunset carousel as a custom post type here
        $customCarouselCPTPage = array(
            'parent_slug'           => 'dutapod_plugin',
            'page_title'            => 'Dutapod Carousel Custom Post Types (stcarousel CPT)',
            'menu_title'            => 'Carousel CPT',
            'capability'            => 'manage_options',
            'menu_slug'             => 'dutapod_plugin_carousel_cpt',
            'callback'              => array($this->callbacks, 'renderAdminCarouselCPTPage')
        );

        $customTaxonomiesPage = array(
            'parent_slug'           => 'dutapod_plugin',
            'page_title'            => 'Dutapod Custom Taxonomies',
            'menu_title'            => 'Taxonomies',
            'capability'            => 'manage_options',
            'menu_slug'             => 'dutapod_plugin_taxonomies',
            'callback'              => array($this->callbacks, 'renderAdminTaxonomyPage')
        );

        $customWidgetsPage = array(
            'parent_slug'           => 'dutapod_plugin',
            'page_title'            => 'Dutapod Custom Widgets (CW)',
            'menu_title'            => 'Widgets',
            'capability'            => 'manage_options',
            'menu_slug'             => 'dutapod_plugin_widgets',
            'callback'              => array($this->callbacks, 'renderAdminWidgetPage')
        );

        $customMenuPage = array(
            'parent_slug'           => 'dutapod_plugin',
            'page_title'            => 'Dutapod Header Navigation menu',
            'menu_title'            => 'Header Menu',
            'capability'            => 'manage_options',
            'menu_slug'             => 'dutapod_plugin_menu',
            'callback'              => array($this->callbacks, 'renderAdminMenuPage')
        );

        $this->subpages = array(
            $customCarouselPage, $customCarouselCPTPage,
            $customTaxonomiesPage, $customWidgetsPage, $customMenuPage
        );
    }//setSubpages
    */

    // Original callback entry: 'callback'              => [ $this->displayCallbacks, 'renderTroubleshootSubpage' ]
    // Original parent_slug entry: 'dutapod_plugin'
    public function setSubpages(){
        $troubleshootSubpage = [
            'parent_slug'           => $this->troubleshootSubpage->parent_slug,
            'page_title'            => $this->troubleshootSubpage->page_title,
            'menu_title'            => $this->troubleshootSubpage->menu_title,
            'capability'            => $this->troubleshootSubpage->capability,
            'menu_slug'             => $this->troubleshootSubpage->menu_slug,
            'callback'              => [ $this->troubleshootSubpage, 'renderPageContent' ]
        ];

        $this->subpages = [ $troubleshootSubpage ];
    }//setSubpages

    /* === Register the custom fields in admin setting pages === */
    public function setSettings(){
        /**
         * Devsunshine plugins features list:
        * - Modular administration area
        * 1 - Custom Post Type (CPT) Manager
        * 2 - Custom Taxonomies Manager
        * 3 - Widget to Upload, Display media in sidebars (Media Widget Manager)
        * 4 - Post, Page Gallery integration (Media Gallery Manager)
        * 5 - Testimonial section (Testimonial Manager)
        * + Comments in front-end
        * + Approval administrations
        * + Select which comments to be displayed
        * 6 - Custom template (Template Manager)
        * 7 - AJAX based login/registered system (Login Manager)
        * 8 - Membership protected area (Membership Manager)
        * 9 - Chat system (Chat Manager)
        * These 9 options in setting pages should be serialize with single option in WordPress database:
        * devsunshine-plugin
        **/

        /**
         * Original entries:
         * - option_group : dutapod-companion_plugin_settings
         * - option_name  : dutapod-companion_plugin
        */
        $settingsArgs = array(
            array(
                'option_group'      => sprintf( '%s_plugin_settings', self::$PLUGIN_NAME),
                'option_name'       => sprintf( '%s_plugin', self::$PLUGIN_NAME ),
                'callback'          => array( $this->callbacksManager, 'checkboxSanitize' ),
            )
        );

        $this->settings->setSettings( $settingsArgs );
    }//setSettings

    public function setSections(){
        $sectionsArgs = array(
          array(
            'id'            => 'dutapod_admin_index',
            'title'         => 'Settings Manager',
            'callback'      => array( $this->callbacksManager, 'dutapodSectionManager' ),
            'page'          => 'dutapod_plugin'
          )
        );
    
        $this->settings->setSections( $sectionsArgs );
    }//setSections

    public function setFields(){

        /* The callback functions are to customize looks and feels  */
        $fieldsArgs = array();

        foreach($this->settingPageManagers as $pageManager){
            $fieldsArgs[] = array(
            'id'            => $pageManager->id,
            'title'         => sprintf('Activate %s', $pageManager->title),
            'callback'      => array($this->callbacksManager, 'displayCheckboxField'),
            'page'          => 'dutapod_plugin',
            'section'       => 'dutapod_admin_index',
            'args'          => array(
                'option_name'   => 'dutapod_plugin',
                'label_for'     => $pageManager->id,
                'class'         => sprintf('ui-toggle %s', $pageManager->classname),
            )
            );
        }

        $this->settings->setFields( $fieldsArgs );
    }//setFields


}//End of class "MenuAdminPages" declaration
