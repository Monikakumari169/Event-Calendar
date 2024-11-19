<?php
/**
 * Template Name: Tribe Events
 */

// Include the header
get_header(); 

// Query for "one-time" category posts

$args_one_time = array(
    'post_type'      => 'tribe_events',
    'posts_per_page' => -1,
    'orderby'        => 'meta_value', // Order by meta value (event date)
    'order'          => 'ASC',
    'meta_key'       => '_EventStartDate', // Replace with your custom field key for event date
    'tax_query'      => array(
        array(
            'taxonomy' => 'tribe_events_cat',
            'field'    => 'slug',
            'terms'    => 'one-time', // Replace with your actual category slug
        ),
    ),
);

$query_one_time = new WP_Query($args_one_time);

// Query for posts from other categories (excluding "one-time")
$args_other = array(
    'post_type'      => 'tribe_events',
    'posts_per_page' => -1,
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
    'meta_key'       => '_EventStartDate',
    'tax_query'      => array(
        array(
            'taxonomy' => 'tribe_events_cat',
            'field'    => 'slug',
            'terms'    => 'one-time', // Exclude "one-time" category
            'operator' => 'NOT IN',
        ),
    ),
);

$query_other = new WP_Query($args_other);
?>
<div class="container">
    <div class="tribe-events-template">
        <?php if ($query_one_time->have_posts()) : ?>
            <h2>One-Time Events</h2>
            <ul class="tribe-events-list">
                <?php while ($query_one_time->have_posts()) : $query_one_time->the_post(); ?>
                    <li class="tribe-event-item">
                        <div class="tribe-event-details">
                            <span class="event-day"><?php echo get_the_date('D'); ?></span>
                            <span class="event-date"><?php echo get_the_date('F j'); ?></span>
                            <span class="event-time">
                                <?php echo tribe_get_start_date(null, false, 'F j, Y @ g:i a'); ?> – 
                                <?php echo tribe_get_end_date(null, false, 'F j, Y @ g:i a'); ?>
                            </span>
                        </div>
                        <h3 class="tribe-event-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="tribe-event-category">
                            <?php
                                $terms = wp_get_post_terms(get_the_ID(), 'tribe_events_cat');
                                foreach ($terms as $term) {
                                    echo '<span class="event-category"> category :- ' . $term->name . '</span>';
                                }
                            ?>
                        </div>
                        <div class="tribe-event-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>

        <?php if ($query_other->have_posts()) : ?>
            <h2>Other Events</h2>
            <ul class="tribe-events-list">
                <?php while ($query_other->have_posts()) : $query_other->the_post(); ?>
                    <li class="tribe-event-item">
                        <div class="tribe-event-details">
                            <span class="event-day"><?php echo get_the_date('D'); ?></span>
                            <span class="event-date"><?php echo get_the_date('F j'); ?></span>
                            <span class="event-time">
                                <?php echo tribe_get_start_date(null, false, 'F j, Y @ g:i a'); ?> – 
                                <?php echo tribe_get_end_date(null, false, 'F j, Y @ g:i a'); ?>
                            </span>
                        </div>
                        <h3 class="tribe-event-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="tribe-event-category">
                            <?php
                                $terms = wp_get_post_terms(get_the_ID(), 'tribe_events_cat');
                                foreach ($terms as $term) {
                                    echo '<span class="event-category">' . $term->name . '</span>';
                                }
                            ?>
                        </div>
                        <div class="tribe-event-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>
<?php
// Include the footer
get_footer();
?>
