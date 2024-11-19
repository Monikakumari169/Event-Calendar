<?php
/**
 * View: List Event
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */


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
 
 <div class="tribe-events-template">
     <?php if ($query_one_time->have_posts()) : ?>
         <h2>One-Time Events</h2>
         <ul class="tribe-events-list">
             <?php while ($query_one_time->have_posts()) : $query_one_time->the_post(); ?>
                 <li class="tribe-event-item">
                     <h3 class="tribe-event-title">
                         <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                     </h3>
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
                     <h3 class="tribe-event-title">
                         <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                     </h3>
                     <div class="tribe-event-excerpt">
                         <?php the_excerpt(); ?>
                     </div>
                 </li>
             <?php endwhile; ?>
         </ul>
     <?php endif; ?>
     <?php wp_reset_postdata(); ?>
 </div>
 


 