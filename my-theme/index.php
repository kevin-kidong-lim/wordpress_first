<?php get_header(); ?>

   <?php
    if(have_posts()): 
        while(have_posts()) : the_post(); 
        ?>
        <article class="post clearfix">
        <?php
        if(has_post_thumbnail()):
            // 워드프레스 설정에 이미 저장된 길이 ..적용
            // the_post_thumbnail('medium');
            // function 에 정의, 파일을 다시 올려야 함..
            the_post_thumbnail('custom');
        else: ?>
            <img class="not-found" src="./wp-content/uploads/2022/02/대박사.png" alt="">
        <?php
        endif;
        ?>
            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
            <p class="post-info"><?php the_time('Y년 n월 j일 a g:i'); ?> | 글쓴이
                    <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author(); ?></a> | 카테고리

                    <?php
                        $categories = get_the_category();
                        $separator = ", ";
                        $output = '';

                        if( $categories ) :
                            foreach( $categories as $category ) :
                                $output .= '<a href="' . get_category_link( $category->term_id ) . '">' . $category->cat_name . '</a>' . $separator;
                            endforeach;
                            echo trim( $output, $separator );
                        endif;
                     ?>
                  </p>
            <?php 
            //전체 정보 가져오기
            // the_content(); 
            // 요약정보만 
                the_excerpt();
            ?>
        </article>
      
       <?php 
       endwhile;
    else:
        echo "post is not";
    endif;

   ?>

<?php get_footer(); ?>