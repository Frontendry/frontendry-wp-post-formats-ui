# frontendry-wp-post-types-ui
Post formats admin UI for both Gutenberg and Classic(TinyMCE) WP Editors.

The supported WP post formats are Video, Gallery, Audio, Link and Quote.

After installing and activating the plugin, you'll get a metabox for the respective post format. 

Use the below field values on your theme. This should be within The Loop. Enjoy!!!

1. For Video Post Format:

    // Best for self-hosted videos, .mp4, .ogg videos

    $video_media = get_post_meta( $post->ID, '_media_video_field', true );

    // To work with wp oEmbed for sites like (YouTube, Vimeo..etc. Have a look at supported platforms - https://codex.wordpress.org/Embeds)

    $o_embedded_media = wp_oembed_get( $video_media );


2. For Gallery Post Format:

    $gallery_media = get_post_meta( $post->ID, '_media_gallery_field', true );

3. For Audio Post Format:

    // Best for self-hosted audios, .mp3 audios

    $audio_media = get_post_meta( $post->ID, '_media_audio_field', true );

    // To work with wp oEmbed for sites like (Spotify, SoundCloud MixCloud, Reverbnation..etc. Have a look at supported platforms - https://codex.wordpress.org/Embeds)

    $o_embedded_media = wp_oembed_get( $audio_media );


4. For Link Post Format:

    $current_link = get_post_meta( $post->ID, '_any_link_field', true );


5. For Quote Post Format:

    $current_quote_author = get_post_meta( $post->ID, '_quote_author_field', true );
