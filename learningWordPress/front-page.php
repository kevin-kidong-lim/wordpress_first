<?php
get_header(); ?>
<div class="site-content clearfix">
    <h3>Custom HTML Here ;;;</h3>
        <?php
        if(have_posts()):
            while(have_posts()): the_post();

                the_content();

            endwhile;

        else:
            echo '<p>No content found</p>';
        endif;   ?>

        <div class="home-columns clearfix">
            <div class="one-harf">
                 <?php
                // opinio posts loop begins here
                $wordpress_dev_posts = new WP_Query('cat=6&posts_per_page=2&orderby=title&order=DESC');

                if($wordpress_dev_posts->have_posts()):
                    while($wordpress_dev_posts->have_posts()): $wordpress_dev_posts->the_post();
                        ?>
                            <h2><a href="<?php the_permalink();?>"><?php the_title();?></a>
                            <?php the_excerpt();?>
                <?php
                    endwhile;

                    else:

                endif;
                wp_reset_postdata();
                ?>
            </div>
            <div class="one-harf last">
            <?php
                // news posts loop begins here
                $wordpress_posts = new WP_Query('cat=5&posts_per_page=2&orderby=title&order=DESC');

                if($wordpress_posts->have_posts()):
                    while($wordpress_posts->have_posts()): $wordpress_posts->the_post();
                        ?>
                            <h2><a href="<?php the_permalink();?>"><?php the_title();?></a>
                            <?php the_excerpt();?>
                <?php
                    endwhile;

                    else:

                endif;
                wp_reset_postdata();
            ?>
            </div>
        </div>

 </div>

<?php
get_footer();
?>