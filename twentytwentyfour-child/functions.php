<?php
/**
 * Enqueue styles and scripts for the child theme using hooks.
 */

function enqueue_child_theme_assets() {
    // Enqueue parent theme style
    wp_enqueue_style(
        'twentytwentyfour-parent-style',
        get_template_directory_uri() . '/style.css'
    );

    // Enqueue child theme CSS
    wp_enqueue_style('twentytwentyfour-child-style',get_stylesheet_directory_uri() . '/assets/css/custom-style.css');

    // Enqueue child theme JS
    wp_enqueue_script(
        'twentytwentyfour-child-script', get_stylesheet_directory_uri() . '/assets/js/script.js', array( 'jquery' ), true);
}
// Hook into wp_enqueue_scripts
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_assets' );


function prioritize_event_categories_in_tec($query) {
    if ( ! is_admin() && $query->is_main_query() && ( is_post_type_archive('tribe_events') || is_tax('tribe_events_cat') ) ) {
        
        $priority_categories = array('one-time', 'evergreen'); 
        

        $tax_query = array(
            array(
                'taxonomy' => 'tribe_events_cat',
                'field'    => 'slug',
                'terms'    => $priority_categories,
                'operator' => 'IN',
            ),
        );

        // Get the existing tax_query from the query (if any) and merge with the new one
        $existing_tax_query = $query->get('tax_query');
        if (!empty($existing_tax_query)) {
            $tax_query = array_merge($tax_query, $existing_tax_query);
        }

        // Set the modified tax_query back into the main query
        $query->set('tax_query', $tax_query);

        // Optionally, set the order and orderby for sorting events by date
        $query->set('orderby', 'meta_value'); 
        $query->set('meta_key', '_EventStartDate');
        $query->set('order', 'DESC');  // Sort events by ascending start date
    }
}
add_action('pre_get_posts', 'prioritize_event_categories_in_tec');

