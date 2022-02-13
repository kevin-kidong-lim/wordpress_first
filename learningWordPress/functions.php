<?php

function loearningWordPress_resources(){
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts','loearningWordPress_resources');


// get top ancestor
function get_top_ancestor_id(){
    global $post;
    if($post->post_parent){
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        return $ancestors[0];
    }
    return $post->ID;
}

//  does page has children?
function has_children(){
    global $post;

    $pages = get_pages('child_of=' . $post->ID);
    return count($pages);
}

// Customize excerpt word count length
function custom_excerpt_length(){
    return 25;
}
add_filter('excerpt_length','custom_excerpt_length');

// Theme setup
function learningWordPress_setup(){
    // Navigation Menus
    register_nav_menus(array(
        'primary' => __('Primary Menu'),
        'footer' => __('Footer Menu'),
    ));

    //add feature image support
    add_theme_support('post-thumbnails');
    add_image_size('small-thumbnail',180, 120, true);
    // array 에 위, 왼쪽 기준으로 크롭 해줌. 
    add_image_size('banner-image',920, 210, array('left','top'));

    // add post format support
    // add_theme_support('post-formats');
    add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link' ) );
}
add_action('after_setup_theme','learningWordPress_setup'); 

//add out widget loaation
function outWidgetsInit(){
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar1',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'  => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'Footer Area 1',
        'id' => 'footer1'
    ));
    register_sidebar(array(
        'name' => 'Footer Area 2',
        'id' => 'footer2'
    ));
    register_sidebar(array(
        'name' => 'Footer Area 3',
        'id' => 'footer3'
    ));
    register_sidebar(array(
        'name' => 'Footer Area 4',
        'id' => 'footer4'
    ));
}

add_action('widgets_init', 'outWidgetsInit');

// function desktop_register_widgets_init() {
//     register_sidebar( array(
//         'name'          => __( 'Main Sidebar', 'textdomain' ),
//         'id'            => 'sidebar-1',
//         'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'textdomain' ),
//         'before_widget' => '<li id="%1$s" class="widget %2$s">',
//         'after_widget'  => '</li>',
//         'before_title'  => '<h2 class="widgettitle">',
//         'after_title'   => '</h2>',
//     ) );
// }
// add_action( 'widgets_init', 'desktop_register_widgets_init' );

// Customize Apprearnce Options
// 관리자 페이지 customize 에 Standard Colors 메뉴가 생성됨..
function learningWordPress_customize_register($wp_customize){
    // controls > ui ( color, text size ...)
    // settings > Database
    // sections > group options ( Widgets, Menus ...)
    $wp_customize->add_setting('lwp_link_color', array(
        'default' => '#006ec3',
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('lwp_btn_color', array(
        'default' => '#006ec3',
        'transport' => 'refresh',
    ));

    $wp_customize->add_section('lwp_starndard_colors', array(
        'title' => __('Standard Colors','LearningWordPress'),
        'priority' => 30,
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( 
        $wp_customize, 'lwp_link-color_control', array(
            'label'=>__('Link Color', 'LearningWordPress'),
            'section'=>'lwp_starndard_colors',
            'settings'=>'lwp_link_color',
        )
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control( 
            $wp_customize, 'lwp_btn-color_control', array(
                'label'=>__('Button Color', 'LearningWordPress'),
                'section'=>'lwp_starndard_colors',
                'settings'=>'lwp_btn_color',
            )
            ));
}
add_action('customize_register','learningWordPress_customize_register');
//Oout put Customize CSS
function learningWordPress_customize_css(){ ?>
    <style type="text/css">
        a:link,
        a:visited{
            color: <?php echo get_theme_mod('lwp_link_color'); ?>;
        }
        .site-header nav ul li.current-menu-item a:link,
        .site-header nav ul li.current-menu-item a:visited,
        .site-header nav ul li.current-page-ancestor a:link,
        .site-header nav ul li.current-page-ancestor a:visited
        {
            background-color:  <?php echo get_theme_mod('lwp_link_color'); ?>;
            color: white;
        }

        /* button */
        .btn-a,
        .btn-a:link,
        .btn-a:visited,
        div.hd-sarch #searchsubmit {
            background-color:  <?php echo get_theme_mod('lwp_btn_color'); ?>;
        }

    </style>
<?php
}
add_action('wp_head','learningWordPress_customize_css');
?>