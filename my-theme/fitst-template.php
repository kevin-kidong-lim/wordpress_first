<?php 
/*
Template Name: Footer Page
*/
get_header();

?>

   <?php
    if(have_posts()): 
        while(have_posts()) : the_post(); 
        ?>
        <article class="post page">
        <h2><?php the_title(); ?></h2>
            <div class="info-box">
                <h4>주의해서 읽어보세요.</h4>
                <p>주의사항입니다.천천히 읽어주세요
                    주의사하입니다. 읽어주숑ㅅ
                </p>
            </div>
            <?php the_content(); ?>
        </article>
      
       <?php 
       endwhile;
    else:
        echo "post is not";
    endif;

   ?>

<?php get_footer(); ?>