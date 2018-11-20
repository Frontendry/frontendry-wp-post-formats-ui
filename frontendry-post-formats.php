<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. 
 *
 * @link              http://www.frontendry.com
 * @since             1.0.0
 * @package           Frontendry_Post_Types
 *
 * @wordpress-plugin
 * Plugin Name:       Frontendry Post Formats 
 * Description:       Post formats admin UI for both Gutenberg and Classic Editors.
 * Version:           1.0.0
 * Author:            Frontendry Themes
 * Author URI:        http://www.frontendry.com
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Initialize
 */

function fpf_initialize(){
    global $post;

    $plugin_url =  plugins_url('', __FILE__);

    wp_enqueue_media();

    wp_enqueue_style( 'fpf-styles', $plugin_url . '/assets/css/fpf-css.css', array(), '' );

    wp_enqueue_script( 'fpf-js', $plugin_url . '/assets/js/fpf-js.js', array('jquery'), '', true );

    wp_localize_script('fpf-js', 'fpf_vars', array(
        'post_format' => get_post_format( $post )
    ));
}
add_action( 'admin_enqueue_scripts', 'fpf_initialize' );

/**
 * Register and create metaboxes
 */
function fpf_add_meta_boxes( $post ){   

    // Video Metabox
	add_meta_box( 
        'fpf-video_metabox',
        __( 'Video URL', 'frontendry-post-formats-plugin' ),
        'render_video_metabox',
        'post',
        'advanced',
        'low'
    );

    // Gallery Metabox
	add_meta_box( 
        'fpf-gallery_metabox',
        __( 'Add gallery images', 'frontendry-post-formats-plugin' ),
        'render_gallery_metabox',
        'post',
        'advanced',
        'low'
    ); 

    // Audio Metabox
	add_meta_box( 
        'fpf-audio_metabox',
        __( 'Audio URL', 'frontendry-post-formats-plugin' ),
        'render_audio_metabox',
        'post',
        'advanced',
        'low'
    );

    // Link Metabox
	add_meta_box( 
        'fpf-link_metabox',
        __( 'Any URL', 'frontendry-post-formats-plugin' ),
        'render_link_metabox',
        'post',
        'advanced',
        'low'
    );

    // Quote Metabox
	add_meta_box( 
        'fpf-quote_metabox',
        __( 'Quote', 'frontendry-post-formats-plugin' ),
        'render_quote_metabox',
        'post',
        'advanced',
        'low'
    );
}
add_action( 'add_meta_boxes_post', 'fpf_add_meta_boxes' );


/**
 * Rendering and saving video metabox 
 */
include( '/render-save/video.php' ) ;

/**
 * Rendering and saving gallery metabox 
 */
 include( '/render-save/gallery.php' ) ;

 /**
 * Rendering and saving audio metabox 
 */
include( '/render-save/audio.php' ) ;

 /**
 * Rendering and saving link metabox 
 */
include( '/render-save/link.php' ) ;

 /**
 * Rendering and saving quote metabox 
 */
include( '/render-save/quote.php' ) ;

?>