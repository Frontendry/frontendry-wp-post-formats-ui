<?php 

function render_video_metabox( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'video_meta_box_nonce' );

    // retrieve the video field current value
    $current_video = get_post_meta( $post->ID, '_media_video_field', true );
    ?>
    
    <div class="inside fpf-inside">    
        <label for="fpf-video-field"><?php _e( 'Place video url below:', 'frontendry-post-formats-plugin' ); ?></label>
        <textarea id="fpf-video-field" name="_media_video_field"><?php echo esc_textarea( $current_video ) ; ?></textarea>
    </div>

    <?php
}

function video_save_meta_box_data( $post_id ){
	// Verify meta box nonce
    if ( !isset( $_POST['video_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['video_meta_box_nonce'], basename( __FILE__ ) ) ){
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
    
    // Store video field values
    if ( !defined('XMLRPC_REQUEST') && isset($_POST['_media_video_field']) ) {
		update_post_meta( $post_id, '_media_video_field', $_POST['_media_video_field']);
	}
}
add_action( 'save_post', 'video_save_meta_box_data', 10, 2 );

?>