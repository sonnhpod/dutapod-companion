<?php

use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\SubpageTroubleshoot as SubpageTroubleshoot;

?>
<h1>Troubleshoot page</h1>
<p>This page is reserved to display some debug information during developing this plugin - at WP admin setting pages scope. </p>
<p> property of the SubpageTroubleshoot can be accessed via the $pageInstance PHP variable </p>
<p>-------------------------------------------------------------------------------------------------------------------------</p>
<table class="wp-options-table">
    <tbody>
        <tr class="header-row">
            <th>Option Name (slug)</th>
            <th>Option value</th>
        </tr><!--.header-row-->
        <?php 
            $pluginNameLowercase = strtolower( SubpageTroubleshoot::$PLUGIN_NAME );
            $options = wp_load_alloptions();//OK  
            // var_dump( $options );
            foreach( $options as $slug => $value ):  
                // Display only option start with the plugin name: dutapod-companion.
                if( str_starts_with( $slug, $pluginNameLowercase ) ){
                    $optionName = esc_attr( $slug );
                    $optionValue = esc_attr( $value );

                    $htmlRow = <<<HTML
                    <tr class="data-row">
                        <td class="option-slug">{$optionName}</td>
                        <td class="option-value">{$optionValue}</td>
                    </tr><!--.data-row-->
                    HTML;
    
                    echo $htmlRow;
                }                      
            endforeach;
        ?>
    </tbody>
</table><!--.wp-options-table -->
<p>-------------------------------------------------------------------------------------------------------------------------</p>

