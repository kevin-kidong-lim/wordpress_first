<?php get_header(); ?>

   <?php
    if(have_posts()): 
        while(have_posts()) : the_post(); 
        ?>
        <article class="post page clearfix">
            <div class="title-column">
                <h2><?php the_title(); ?> Portfolio</h2>
            </div>
            <div class="content-column">
                <?php the_content(); ?>
            </div>
        </article>
      
       <?php 
       endwhile;
    else:
        echo "post is not";
    endif;

   ?>

<?php get_footer(); ?>