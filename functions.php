<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'twenty-twenty-one-style'; // This is 'twenty-twenty-one-style' for the Twenty Twenty-one theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'custom-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}
add_action( 'twenty_twenty_one_entry_meta_footer', 'child_entry_meta_footer' );
function child_entry_meta_footer() {
    // Early exit if not a post.
    if ( 'post' !== get_post_type() ) {
        return;
    }

    // Hide meta information on pages.
    if ( ! is_single() ) {

        if ( is_sticky() ) {
            echo '<p>' . esc_html_x( 'Featured post', 'Label for sticky posts', 'twentytwentyone' ) . '</p>';
        }

        $post_format = get_post_format();
        if ( 'aside' === $post_format || 'status' === $post_format ) {
            echo '<p><a href="' . esc_url( get_permalink() ) . '">' . twenty_twenty_one_continue_reading_text() . '</a></p>'; // phpcs:ignore WordPress.Security.EscapeOutput
        }

        // Posted on.
        twenty_twenty_one_posted_on();
        
    } else {

        echo '<div class="posted-by">';
        // Posted on.
        twenty_twenty_one_posted_on();
        
    }
}
