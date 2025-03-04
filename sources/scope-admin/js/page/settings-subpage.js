/** Package dutapod-companion WordPresss plugin  */
// console.log('Hello world from the settings-management-subpage.js !');

jQuery(document).ready( function( $ ){
    let mediaUploader;

    /** 1. Add click event listener for upload button */ 
    $( '#upload-logo-button-id' ).click( function( e ){
        e.preventDefault();

        // 1.1. If the media uploader has already existed, open it
        if( mediaUploader ){
            mediaUploader.open();
            return ;
        }

        // 1.2. If the media uploader has not been existed, create a new one
        mediaUploader = wp.media({
            title: 'Choose Logo Image',
            button: {
                text: 'Use this logo'
            },
            multiple: false
        });

        // When an image is selected, set the input field 
        mediaUploader.on( 'select', function(){
            let attachment = mediaUploader.state().get('selection').first().toJSON();
            $( '#plugin-company-logo-id' ).val( attachment.url );
            $( '#plugin-company-logo-preview-id' ).attr( 'src', attachment.url ).show();
            $( '#remove-logo-button-id' ).show();
        } );

        // Open the uploader dialog
        mediaUploader.open();
    });

    /** 2. Add click event listener for remove button */ 
    $( '#remove-logo-button-id' ).click( function(){
        $( '#plugin-company-logo-id' ).val( '' );
        $( '#plugin-company-logo-preview-id' ).hide();
        $(this).hide();
    } );
} );