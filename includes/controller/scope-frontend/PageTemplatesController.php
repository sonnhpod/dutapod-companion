<?php 
/** 
 * @package vncslab-companion
 * @version 1.0.1
 */


namespace DutapodCompanion\Includes\Controller\ScopeFrontend;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Includes\Base\Activator as Activator;

// 1. Debug class
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;
use DutapodCompanion\Includes\Base\BaseController as BaseController;

// 2. Page template class
use DutapodCompanion\Includes\Controller\ScopeFrontend\PageTemplate\DebugPageTemplate as DebugPageTemplate;
use DutapodCompanion\Includes\Controller\ScopeFrontend\PageTemplate\CustomPageTemplate as CustomPageTemplate;
use DutapodCompanion\Includes\Controller\ScopeFrontend\PageTemplate\OrderTrackingPageTemplate as OrderTrackingPageTemplate;
/**
 * 1. Manage all WordPress page templates
*/
class PageTemplatesController extends BaseController{

    /** 1. Variable declaration */
    // 1.1. Manage the page template list
    public static array $PAGE_TEMPLATES;// Tracking variables to manage Page template instances
    public static array $PAGE_TEMPLATES_LIST;// // List of the page template instances name

    // 2. detail page object
    // public DebugPageTemplate $debugPageTemplate;
    // public CustomPageTemplate $customPageTemplate;
    // public OrderTrackingPageTemplate $orderTrackingPageTemplate;

    /** 2. Constructor */
    public function __construct(){
        parent::__construct();        
        
        // 2. Initialize the page template list
        self::$PAGE_TEMPLATES_LIST = [
            DebugPageTemplate::class,
            CustomPageTemplate::class,
            OrderTrackingPageTemplate::class,
        ];
    }//__construct

    /** 3. Main operational functions */
    /** 3.1. Register all page templates services to the plugin workflow */
    public function register(){
        // Iterate through each page name in the page list
        foreach( self::$PAGE_TEMPLATES_LIST as $pageTemplateName ){
            if( class_exists( $pageTemplateName ) ){
                // 1. Initialize the corresponding page name
                $pageTemplate = new $pageTemplateName();

                // 2. Register each page name to the WP plugin's workflow
                $pageTemplate->register();

                // 3. Add to the PAGES list for tracking purpose
                self::$PAGE_TEMPLATES[ $pageTemplateName ] = $pageTemplate;
            }            
        }//self::$PAGES_LIST as $page
    }//register

}//PageTemplatesController