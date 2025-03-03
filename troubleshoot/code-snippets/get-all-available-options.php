<h3>Display all WordPress options in wp_options table </h3>

<table class="wp-options-table">
    <tbody>
        <tr class="header-row">
            <th>Option Slug</th>
            <th>Option value</th>
        </tr><!--.header-row-->
        <?php 
            $options = wp_load_alloptions();//OK  
            // var_dump( $options );
            foreach( $options as $slug => $value ): 
                $htmlRow = <<<HTML
                <tr class="data-row">
                    <td class="option-slug">{$slug}</td>
                    <td class="option-value">{$value}</td>
                </tr><!--.data-row-->
                HTML;

                echo $htmlRow;
            endforeach;
        ?>
    </tbody>
</table><!--.wp-options-table -->