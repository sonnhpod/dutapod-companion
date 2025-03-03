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
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\ProductPage as WcProductPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\CategoryPage as WcCategoryPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\TagPage as WcTagPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\ShopPage as WcShopPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\CartPage as WcCartPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\CheckoutPage as WcCheckoutPage;
// use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\Shortcode as WcShortcode;

class WcPagesController extends BaseController{

    /** 1. Variable declaration */
    // 1.1. Manage the page template list
    public static array $PAGES;// Tracking variables to manage PAGE instance
    public static array $PAGES_LIST; // List of the page instances name

    // public WcProductPage $productPage;
    // public WcCategoryPage $categoryPage;
    // public WcTagPage $tagPage;
    // public WcShopPage $shopPage;
    // public WcCartPage $cartPage;
    // public WcCheckoutPage $checkoutPage;

    /** 2. Constructor */
    public function __construct(){
        parent::__construct();        
        
        // $this->orderTrackingPageTemplate = new OrderTrackingPageTemplate();
        self::$PAGES_LIST = [
            WcProductPage::class,
            WcCategoryPage::class,
            WcTagPage::class,
            WcShopPage::class,
            WcCartPage::class,
            WcCheckoutPage::class,
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

}//WcPagesController class definition