<?php 
/**
* Template Name: dutapod Debug Template
* Template Post Type: page, post, product
*/
/* Package dutapod-companion 
* This page template is used to display directly the problematic variables 
*/

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Includes\Controller\ScopeFrontend\ThemeCustomizer as ThemeCustomizer;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerceCustomizer as WooCommerceCustomizer;



global $post;

$pluginProperties = Init::$FRONTEND_INSTANCES_LIST[ PluginProperties::class ];
$themeCustomizer = Init::$FRONTEND_INSTANCES_LIST[ ThemeCustomizer::class ];
// If need to write log in a separate dutapod-companion-debug.log
$pluginDebugger = Init::$FRONTEND_INSTANCES_LIST[ PluginDebugHelper::class ];

# $wcCustomizer = Init::$FRONTEND_INSTANCES_LIST[ WooCommerceCustomizer::class ];

?>

<!-- Preprocessing some data & information before displaying the debug page -->


<!-- 1. Displaying the debug page template header -->
<?php get_header() ?>

<!-- 2. Displaying the debug page body - content that need to be debug -->

<div id="body-primary" class="dutapod-component-content-area">

    <div id="dutapod-custom-content-wrapper-id" class="dutapod-custom-content-wrapper">
        <h3>This is the dutapod-COMPANION custom content header </h3>
        <pre>Current OS information: <?php echo PHP_OS; ?> </pre>
    </div><!--div#dutapod-content-wrapper-id-->


    <p>========== start the detail of the post ================== </p>
    <div id="dutapod-content-wrapper-id" class="dutapod-content-wrapper">
        <?php // the_content(); ?>

        <?php // var_dump( WooCommerceCustomizer::$WC_CURRENT_THEME ); ?>
        <?php // echo '<pre>' . var_export( get_page_template() , true) . '</pre>'; ?>
    </div><!--div#dutapod-content-wrapper-id-->
    <p>========== Start of debugging area ================== </p>
    <?php // var_dump( $themeCustomizer );//OK ?>
    <?php // echo '<pre>' . var_export($wcCustomizer, true) . '</pre>';//OK ?>



    <p>========== End of debugging area ================== </p>

</div><!-- #body-primary -->


<!-- 3. Displaying the debug page template footer -->
<!-- Get footer by loading the template footer.php -->
<?php get_footer() ?>