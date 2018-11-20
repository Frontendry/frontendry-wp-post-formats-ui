<?php 

function render_link_metabox( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'link_meta_box_nonce' );

    // retrieve the link field current value
    $current_link = get_post_meta( $post->ID, '_any_link_field', true );
    ?>
    
    <div class="inside fpf-inside">    
        <label for="fpf-link-field"><?php _e( 'Place any url below:', 'frontendry-post-formats-plugin' ); ?></label>
        <textarea id="fpf-link-field" name="_any_link_field"><?php echo esc_textarea( $current_link ) ; ?></textarea>    
    </div>

    <?php
}

function link_save_meta_box_data( $post_id ){
	// Verify meta box nonce
    if ( !isset( $_POST['link_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['link_meta_box_nonce'], basename( __FILE__ ) ) ){
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
    
    // Store link field values
    if ( !defined('XMLRPC_REQUEST') && isset($_POST['_any_link_field']) ) {
		update_post_meta( $post_id, '_any_link_field', sanitize_text_field( $_POST['_any_link_field'] ) );
	}
}
add_action( 'save_post', 'link_save_meta_box_data', 10, 2 );

?>