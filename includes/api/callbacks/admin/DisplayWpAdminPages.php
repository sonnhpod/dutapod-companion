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

    public object $contentTypes; 

    public function __construct(){
        $this->contentTypes = new stdClass();

        // Create the generic content objects here
        $this->contentTypes->sunsetMenu = new stdClass();
        $this->contentTypes->sunsetCarousel = new stdClass();
        $this->contentTypes->sunsetWidget = new stdClass();
        $this->contentTypes->sunsetTemplate = new stdClass();
    }//__construct

    public function renderAdminParentRootPage(){
        // require_once("$this->pluginPath/templates/admin/admin-parent-root.php");
        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/dutapod-parent-root.php" );
    }//renderAdminParentRootPage

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

    public function renderAdminTroubleshootPage(){
        // require_once("$this->pluginPath/includes/template/scope-admin/admin-page-troubleshoot.php");
        require_once( self::$PLUGIN_PATH."/includes/template/scope-admin/admin-page-troubleshoot.php" );
    }

}//End of SunsetproAdmin(callback) definition