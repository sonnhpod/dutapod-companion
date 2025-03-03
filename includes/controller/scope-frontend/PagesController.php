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

// 2. Detail WP Page object
use DutapodCompanion\Includes\Controller\ScopeFrontend\Page\GeneralPages as GeneralPages;
use DutapodCompanion\Includes\Controller\ScopeFrontend\Page\FrontPage as FrontPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\Page\OrderTrackingPage as OrderTrackingPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\Page\AboutUsPage as AboutUsPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\Page\TestPage as TestPage;

class PagesController extends BaseController{

    /** 1. Variable declaration */
    // 1.1. Manage the page template list
    public static array $PAGES;// Tracking variables to manage PAGE instance
    public static array $PAGES_LIST; // List of the page instances name

    // public GeneralPages $generalPages;
    // public FrontPage $frontPage;
    // public OrderTrackingPage $orderTrackingPage;
    // public AboutUsPage $aboutUsPage;
    // public TestPage $testPage;

    /** 2. Constructor */
    public function __construct(){
        // 1. Initialize parent constructor
        parent::__construct();        
        
        /** 2. Initialize page list instance. Class name must be placed at right order
        * - Class name is the name of each class with full namespace.  
        * For example: DutapodCompanion\Includes\Controller\ScopeFrontend\Page\FrontPage
        */
        self::$PAGES_LIST = [
            GeneralPages::class,
            FrontPage::class,
            OrderTrackingPage::class,
            AboutUsPage::class,
            TestPage::class,
        ];
    }//__construct

     /** 3. Main operational functions */
    /** 3.1. Register all page templates services to the plugin workflow */
    public function register(){       
        // Iterate through each page name in the page list
        foreach( self::$PAGES_LIST as $pageName ){
            if( class_exists( $pageName ) ){
                // 1. Initialize the corresponding page name
                $page = new $pageName();

                // 2. Register each page name to the WP plugin's workflow
                $page->register();

                // 3. Add to the PAGES list for tracking purpose
                self::$PAGES[ $pageName ] = $page;
            }            
        }//self::$PAGES_LIST as $page
    }//register

}//PagesController class definition