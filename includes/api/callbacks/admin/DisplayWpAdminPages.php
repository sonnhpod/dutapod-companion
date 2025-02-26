<?php
/*
 * @package Sunsetpro
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */
namespace DutapodCompanion\Includes\Api\Callbacks\Admin;

use \stdClass;
use DutapodCompanion\Includes\Base\BaseController as BaseController;

class DisplayWpAdminPages extends BaseController{

    /** 1. Variables declaration */
    // 1.1. Store the instance of this class. This is to create a singleton class
    private static $INSTANCE = null;

    public object $contentTypes; 

    /** 2. Constructor */
    public function __construct(){
        $this->contentTypes = new stdClass();

        // Create the generic content objects here
        $this->contentTypes->sunsetMenu = new stdClass();
        $this->contentTypes->sunsetCarousel = new stdClass();
        $this->contentTypes->sunsetWidget = new stdClass();
        $this->contentTypes->sunsetTemplate = new stdClass();
    }//__construct

    /** 2.2. Helper function for constructor */
    public static function getInstance(){
        if( null == self::$INSTANCE ){
            self::$INSTANCE = new DisplayWpAdminPages();
        }

        return self::$INSTANCE;
    }//getInstance

    /** 3. Operational functions to display WP admin pages content */
    /** 3.1. Callback function to render the plugin's admin parent root page */
    public function renderAdminParentRootPage(){
        // require_once("$this->pluginPath/templates/admin/admin-parent-root.php");
        // require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/dutapod-parent-root.php" );
        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/admin-parent-root.php" );
    }//renderAdminParentRootPage

    /** 3.2. Callback function to render the plugin's troubleshoot page */
    
    public function renderTroubleshootSubpage(){
        // require_once("$this->pluginPath/includes/template/scope-admin/admin-page-troubleshoot.php");
        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/troubleshoot-subpage.php" );
    }//renderTroubleshootSubpage

    /************************************************************************************************/
    /** 3.3.+ Other callback functions to render additional admin setting pages */
    public function renderAdminCarouselPage(){
        // require_once("$this->pluginPath/templates/admin/admin-cpt.php");
        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/dutapod-carousel.php" );
    }//renderAdminCPTPage

    public function renderAdminCarouselCPTPage(){
        // require_once("$this->pluginPath/templates/admin/admin-cpt.php");
        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/dutapod-carousel-cpt.php" );
    }//renderAdminCarouselCPTPage

    public function renderAdminTaxonomyPage(){
        // require_once("$this->pluginPath/templates/admin/admin-taxonomies.php");
        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/dutapod-taxonomy.php" );
    }//renderAdminTaxonomiesPage

    public function renderAdminWidgetPage(){
        // require_once("$this->pluginPath/templates/admin/admin-widgets.php");
        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/dutapod-widget.php" );
    }//renderAdminWidgetsPage

    public function renderAdminMenuPage(){
        // require_once("$this->pluginPath/templates/admin/admin-widgets.php");
        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/dutapod-menu.php" );
    }//renderAdminWidgetsPage 


}//End of SunsetproAdmin(callback) definition