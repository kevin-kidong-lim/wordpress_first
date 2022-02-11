<?php get_header(); ?>

   <?php
    if(have_posts()): 
        while(have_posts()) : the_post(); 
        ?>
        <article class="post page">
            <h2><?php the_title(); ?></h2>
            <?php
            // var_dump($post);
            // var_dump( array_reverse(get_post_ancestors($post->ID)));
            ?>
            <?php
            // id의 자식만 나오게.
                $args = array(
                //    'child_of' => $post->ID,
                   'child_of' =>get_top_parent_id(),
                   'title_li' => '',
                );
            ?>
            <div class="content-box">
                <nav class="site-nav sub-nav">
                    <ul>
                    <?php wp_list_pages( $args) ?>
                    </ul>
                </nav>
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