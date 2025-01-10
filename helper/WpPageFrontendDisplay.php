<?php 
/**
 * @package vncslab-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Helper;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

use DOMWrap\Document as Document;
use Symfony\Component\DomCrawler\Crawler as SymfonyCrawler;
use DOMDocument;


class WpPageFrontendDisplay{
    /** 1. Const & Variables declarations*/

    const WP_PAGE_EXAMINED_LIST = [ 4079 ];

    /** 1.2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    /** 2. Constructors */
    public function __construct(){
        /** 1. Troubleshooting information */
        // 1.1. Load the plugin initiator
        $this->pluginInitiator = Init::$INSTANCE ?? new Init();
        
        // 1.2. Setup local properties
        $this->setLocalProperties();

        // 1.3. Setup local debuggger
        $this->setLocalDebugger();

        /** 2. Setup local properties */

        /** 3. Run the main functions */
        /** 3.1. Customize the HTML Output if matching the requirements */
        /** - Add to the filter hook: */
        // add_action('pre_get_posts', [$this, 'customize_HTML_output_If_Post_4079'] );
        // template_redirect would be the most appropriate
        // add_action('the_post', [$this, 'customize_HTML_output_If_Post_4079'] );
        // $this->customize_HTML_output_If_Post_4079(); //OK. Get the OutputHTML Content
        // add_action('template_redirect', [$this, 'customize_HTML_output_If_Post_4079'] );
    }//__construct

    /** 2.2. Helper methods for constructor */
    /** 2.2.1. Initialize the variable that point to general plugin properties */ 
    public function setLocalProperties():void{
        $this->localProps =  $this->pluginInitiator::$PLUGIN_PROPERTIES;
    }//setLocalProperties

    /** 2.2.2. setup the custom debugger for plugin */ 
    public function setLocalDebugger():void{
        $this->localDebugger = $this->pluginInitiator::$PLUGIN_DEBUGGER;
    }//setLocalDebugger    

    /** 3. Main operation of the page frontend display */


}//WpPageFrontendDisplay class definition