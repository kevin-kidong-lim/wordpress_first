<?php
function my_enqueue_script(){
    wp_enqueue_style('style',get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_enqueue_script');


//menu 
// register_nav_menu( array(
//     'primary' => __('Primary Menu'),
//     'footer' => __('Footer Menu'),
// ));

function wpb_custom_new_menu() {
    register_nav_menus(
      array(
        'primary' => __( 'Primary Menu' ),
        'footer' => __( 'Footer Menu' )
      )
    );
  }
add_action( 'init', 'wpb_custom_new_menu' );
// 상위 페이지 아이디 가져오기
function get_top_parent_id(){
    global $post;
    if ($post->post_parent):
        $ancestor = array_reverse(get_post_ancestors($post->ID));
        return $ancestor[0];
    endif;
    return $post->ID;
}

// 테마 셋업
function my_theme_setup(){
    //메뉼등록
    //포스트 썸네일 등록
    add_theme_support('post-thumbnails');
    //true 비율따지지 않고 짤라줌..
    add_image_size('custom', 320,200,true);
}
add_action('after_setup_theme', 'my_theme_setup');
?>