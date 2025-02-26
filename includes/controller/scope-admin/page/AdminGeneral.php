<?php 
/*
 * @package Sunsetpro
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Controller\ScopeAdmin\Page;

use DutapodCompanion\Includes\Base\BaseController as BaseController;

use DutapodCompanion\Includes\Api\SettingsAdminPages as SettingsAdminPages;
// use SunsetPro\Includes\Api\Callbacks\Admin\AdminParentCallbacks as AdminParentCallbacks;
use DutapodCompanion\Includes\Api\Callbacks\Admin\DisplayWpAdminPages as DisplayWpAdminPages;
use DutapodCompanion\Includes\Api\Callbacks\Admin\AdminManagerCallbacks as AdminManagerCallbacks;

class AdminGeneral extends BaseController{

    public SettingsAdminPages $settings;
    // public SunsetproAdmin $callbacks;
    public DisplayWpAdminPages $callbacks;
    public AdminManagerCallbacks $callbacksManager;

    // An array that store a list of a parent admin setting page.
    public array $pages;   
    // Sub page corresponding with each parent page
    public array $subpages;

    public function __construct(){
        parent::__construct();
    }//__construct

    public function register(){
        $this->settings = new SettingsAdminPages();

        //$this->callbacks = new SunsetproAdmin();
        $this->callbacks = new DisplayWpAdminPages();
        $this->callbacksManager = new AdminManagerCallbacks();

        $this->setPages();
        $this->setSubpages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        // 1. Register admin setting pages from plugin
        // - "Control Dashboard" is the original value of withSubPage method
        $this->settings->addAdminPages( $this->pages )->withSubPage( 'Overview' )->addSubPages( $this->subpages )->register();
    }//register

    /* === Register the main pages in WordPress Admin setting pages === */
    public function setPages(){
        // 1. Admin parent root page of this plugin - Dutapod
        $this->pages = array(
            array(
                'page_title'    => 'Dutapod Plugin',
                'menu_title'    => 'Dutapod Companion',
                'capability'    => 'manage_options',
                'menu_slug'     => 'dutapod_plugin',
                'callback'      => array($this->callbacks, 'renderAdminParentRootPage'),
                'icon_url'      => 'dashicons-welcome-widgets-menus',
                'position'      => 121,
            )
        );
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

    public function setSubpages(){
        $troubleshootPage = [
            'parent_slug'           => 'dutapod_plugin',
            'page_title'            => 'Dutapod troubleshoot page',
            'menu_title'            => 'Troubleshoot',
            'capability'            => 'manage_options',
            'menu_slug'             => 'dutapod_plugin_troubleshoot',
            'callback'              => array($this->callbacks, 'renderAdminTroubleshootPage')
        ];

        $this->subpages = [ $troubleshootPage ];
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

        $settingsArgs = array(
            array(
                'option_group'      => 'dutapod_plugin_settings',
                'option_name'       => 'dutapod_plugin',
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
            'callback'      => array($this->callbacksManager, 'dutapodSectionManager'),
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


}//End of class "Admin" declaration
