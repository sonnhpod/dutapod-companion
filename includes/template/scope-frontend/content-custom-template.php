<?php 
/*
* Template Name: DUTAPOD Debug Template
* Template Post Type: page, post, product
*/

/* Package dutapod-companion */
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Includes\Init as Init;

/** 
 * This is a custom template to implement custom queries
*/

global $post;

$pluginProperties = Init::$FRONTEND_INSTANCES_LIST[ PluginProperties::class ];

?>

<!-- Preprocessing some data & information before displaying the debug page -->


<!-- 1. Displaying the debug page template header -->
<?php get_header() ?>

<!-- 2. Displaying the debug page body - content that need to be debug -->

<div id="body-primary" class="dutapod-component-content-area">

    <h2> The Custom Page of dutapod-companion plugin - generated from "DUTAPOD Custom Template" </h2>

    <pre>Current OS information: <?php echo PHP_OS; ?> </pre>

    <div id="dutapod-content-wrapper-id" class="dutapod-content-wrapper">
        <?php the_content(); ?>
    </div><!--div#dutapod-content-wrapper-id-->
    <div id="dutapod-custom-content-wrapper-id" class="dutapod-custom-content-wrapper">
        <h3>This is the DUTAPOD-COMPANION custom content header </h3>
        <p> Easy learn, Easy earn </p>
        <p> Try your best to overcome any difficulty in your life to get thing we want. We only live once.  </p>
    </div><!--div#dutapod-content-wrapper-id-->
</div><!-- #body-primary -->


<!-- 3. Displaying the debug page template footer -->
<!-- Get footer by loading the template footer.php -->
<?php get_footer() ?>