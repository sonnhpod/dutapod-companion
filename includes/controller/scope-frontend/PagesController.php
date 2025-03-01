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
    public static array $PAGES;

    public GeneralPages $generalPages;
    public FrontPage $frontPage;
    public OrderTrackingPage $orderTrackingPage;
    public AboutUsPage $aboutUsPage;
    public TestPage $testPage;

    /** 2. Constructor */
    public function __construct(){
        parent::__construct();        
        
        // $this->orderTrackingPageTemplate = new OrderTrackingPageTemplate();
    }//__construct

     /** 3. Main operational functions */
    /** 3.1. Register all page templates services to the plugin workflow */
    public function register(){
        // 1. General pages object stands for all WordPress page. 
        $this->generalPages = new GeneralPages();
        $this->generalPages->register();

        // 1. Front page or home page
        $this->frontPage = new FrontPage();
        $this->frontPage->register();

        // 2. Order tracking page
        $this->orderTrackingPage = new OrderTrackingPage();
        $this->orderTrackingPage->register();

        // 3. About us page 
        $this->aboutUsPage = new AboutUsPage();
        $this->aboutUsPage->register();

        // Final - test page
        $this->testPage = new TestPage();
        $this->testPage->register();
    }//register

}//PagesController class definition