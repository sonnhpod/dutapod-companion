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
    public static array $PAGES;

    public WcProductPage $productPage;
    public WcCategoryPage $categoryPage;
    public WcTagPage $tagPage;
    public WcShopPage $shopPage;
    public WcCartPage $cartPage;
    public WcCheckoutPage $checkoutPage;

    /** 2. Constructor */
    public function __construct(){
        parent::__construct();        
        
        // $this->orderTrackingPageTemplate = new OrderTrackingPageTemplate();
    }//__construct

     /** 3. Main operational functions */
    /** 3.1. Register all page templates services to the plugin workflow */
    public function register(){
        // 1. Register all relevant WooCommerce Product page
        // 1.1. WooCommerce product page
        $this->productPage = new WcProductPage();
        $this->productPage->register();

        // 1.2. WooCommerce product category page
        $this->categoryPage = new WcCategoryPage();
        $this->categoryPage->register();

        // 2. Order tracking page
        $this->tagPage = new WcTagPage();
        $this->tagPage->register();

        // 2. Payment page
        // 2.1. Shop page
        $this->shopPage = new WcShopPage();
        $this->shopPage->register();

        // 2.2. Cart page
        $this->cartPage = new WcCartPage();
        $this->cartPage->register();

        // 2.3. Checkout page
        $this->checkoutPage = new WcCheckoutPage();
        $this->checkoutPage->register();
    }//register

}//WcPagesController class definition