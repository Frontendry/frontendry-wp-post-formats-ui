<?php 


function render_gallery_metabox() {
    global $post;

    wp_nonce_field( basename( __FILE__ ), 'gallery_meta_box_nonce' );

    // retrieve the gallery field current value
    $current_gallery = get_post_meta( $post->ID, '_media_gallery_field', true );
    ?>

    <div class="inside fpf-inside">    
        <label for="fpf-gallery-field"><?php _e( 'Add gallery images below:', 'frontendry-post-formats-plugin' ); ?></label>
        <div id="fpf-gallery-field" class="fpf-gallery-cont">
            <div class="fpf-gallery-cont-in">
                <div class="fpf-gallery-eles">
                    <?php
                    if ( $current_gallery ) {
                        foreach ($current_gallery as $image) {
                            $thumbnail = wp_get_attachment_image_src($image, 'thumbnail');
                            echo '<div class="fpf-gallery-ele" data-img-id="' . $image . '"><img src="' . $thumbnail[0] . '" alt="" /><span class="remove-img">x</span></div>';
                        }
                    }
                    
                    ?>
                </div>

                <div class="cta-cont">
                    <button class="gallery-upload" type="button"><?php echo __( 'Add gallery image(s)', 'frontendry-post-formats-plugin' );?> </button>
                </div>

                <input id="fpf-gallery-id-field" name="_media_gallery_field" type="hidden" value="<?php echo (empty($current_gallery) ? "" : implode(',', $current_gallery)); ?>" />
            </div>
        </div>        
    </div>

    <?php
}

function gallery_save_meta_box_data( $post_id ){
	// Verify meta box nonce
    if ( !isset( $_POST['gallery_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['gallery_meta_box_nonce'], basename( __FILE__ ) ) ){
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

    // Store gallery field values
    if ( !defined('XMLRPC_REQUEST') && isset($_POST['_media_gallery_field']) ) {
		global $post;
		if( $_POST['_media_gallery_field'] !== '' ) {
			$images = explode(',', $_POST['_media_gallery_field']);
		} else {
			$images = array();
		}
		update_post_meta($post_id, '_media_gallery_field', $images);
	}
}
add_action( 'save_post', 'gallery_save_meta_box_data', 10, 2 );


?>