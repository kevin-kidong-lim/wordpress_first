<?php
get_header(); ?>
<div class="site-content clearfix">
    <div class="main-column">
        <?php
        if(have_posts()):
            while(have_posts()): the_post();
        
            // 여러 옵션이 있다 ..
            /*
            Post Formats
            - Aside, gallery, link
            Image, quote, status, video, audio, chat
            1. enable post format > function.php > setup()
            2. 
        */
            get_template_part('content', get_post_format());
            // get_template_part('content', 'home'');
            // get_template_part('content');
            endwhile;

        else:
            echo '<p>No content found</p>';
        endif;  ?>
        </div>
        
        <!-- side bar  sidebar.php -->
        <?php get_sidebar();?>
</div>
   


<?php
get_footer();
?>