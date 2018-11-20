<?php 

function render_quote_metabox( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'quote_meta_box_nonce' );

    // retrieve the respective quote field current value
    $current_quote_author = get_post_meta( $post->ID, '_quote_author_field', true );
    ?>
    
    <div class="inside fpf-inside">    
        <label for="fpf-quote_author-field"><?php _e( 'Place quote author below:', 'frontendry-post-formats-plugin' ); ?></label>
        <input type="text" id="fpf-quote_author-field" name="_quote_author_field" value="<?php echo esc_attr( $current_quote_author ); ?>">    
     </div>

    <?php
}

function quote_save_meta_box_data( $post_id ){
	// Verify meta box nonce
    if ( !isset( $_POST['quote_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['quote_meta_box_nonce'], basename( __FILE__ ) ) ){
	    return;
    }

    // Return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
    }
    
    // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
    }
    
    // Store respective quote field values
    if( !defined('XMLRPC_REQUEST') ) {
        if( isset($_POST['_quote_author_field']) ) {
            update_post_meta( $post_id, '_quote_author_field', sanitize_text_field( $_POST['_quote_author_field'] ) );
        }
    }
    
}
add_action( 'save_post', 'quote_save_meta_box_data', 10, 2 );

?>