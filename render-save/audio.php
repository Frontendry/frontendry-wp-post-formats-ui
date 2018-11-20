<?php 

function render_audio_metabox( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'audio_meta_box_nonce' );

    // retrieve the audio field current value
    $current_audio = get_post_meta( $post->ID, '_media_audio_field', true );
    ?>
    
    <div class="inside fpf-inside">    
        <label for="fpf-audio-field"><?php _e( 'Place audio url below:', 'frontendry-post-formats-plugin' ); ?></label>
        <textarea id="fpf-audio-field" name="_media_audio_field"><?php echo esc_textarea( $current_audio ) ; ?></textarea>
    </div>

    <?php
}

function audio_save_meta_box_data( $post_id ){
	// Verify meta box nonce
    if ( !isset( $_POST['audio_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['audio_meta_box_nonce'], basename( __FILE__ ) ) ){
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
    
    // Store audio field values
    if ( !defined('XMLRPC_REQUEST') && isset($_POST['_media_audio_field']) ) {
		update_post_meta( $post_id, '_media_audio_field',  $_POST['_media_audio_field'] );
	}
}
add_action( 'save_post', 'audio_save_meta_box_data', 10, 2 );

?>