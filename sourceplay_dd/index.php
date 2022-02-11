<?php
/*
Plugin Name: sourceplay_dd
Plugin URI: https://wordpress.com/
Description: dollar translate to current dollar
Version: 1.0.0
Author: Kevin Lim
Author URI: https://word.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: kevin
*/
function getContents($webpage) // 웹페이지 내용 가져오기
{
    $ch = curl_init($webpage);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    curl_setopt($ch, CURLOPT_TIMEOUT, 400);

    $webcontents = curl_exec($ch);
    curl_close($ch);
    return $webcontents;
}
function findStringBetweenAnB($dest, $A, $B)
{
    $firstFindIdx = strpos($dest, $A);
    $firstFindIdx = $firstFindIdx + strlen($A);
    $secondFindIdx = strpos($dest, $B, $firstFindIdx);

    $finalSearString = trim(substr($dest, $firstFindIdx,$secondFindIdx-$firstFindIdx));
    return $finalSearString;
}
add_action( 'init', 'source_playground_dollar_receive_rate' );
function source_playground_dollar_receive_rate(){
    // crontab 에서 주기적으로 .실행
    // 1 */1 * * /usr/bin/curl -s -o /dev/null http://word/GET_DOLLAR=OK
    // 주기적으로 샐행을 하게 만든다..
    // crontab -e
    global $wpdb;
    if(isset($_GET['GET_DOLLAR'])):
        if($_GET["GET_DOLLAR"] == "OK"):
            $dollarSource = "https://www.google.com/search?q=dollar+rate&newwindow=1&sxsrf=APq-WBuPR-t56RP6-GvZGUkWlmW3q6-tlg%3A1644602216758&ei=aKMGYqaxLdXK0PEPsqiMqAE&ved=0ahUKEwimhbTXnPj1AhVVJTQIHTIUAxUQ4dUDCA4&uact=5&oq=dollar+rate&gs_lcp=Cgdnd3Mtd2l6EAMyEAgAELEDEIMBEJECEEYQggIyBQgAEJECMgUIABCRAjIFCAAQgAQyBQgAEIAEMgUIABCABDIFCAAQgAQyCAgAEIAEEMkDMgUIABCABDIFCAAQgAQ6CwguEIAEEMcBEKMCOgsILhCABBDHARDRAzoFCC4QgAQ6BAgjECc6BwgjEOoCECc6DgguEIAEELEDEMcBEKMCOggIABCABBCxAzoLCAAQgAQQsQMQgwE6CAguELEDEIMBOgoIABCxAxCDARBDOgQIABBDOgsILhCABBCxAxDUAjoICAAQsQMQgwE6CwgAEIAEELEDEMkDOgUIABCSAzoICC4QgAQQsQM6CwgAELEDEIMBEJECOgsILhCABBDHARCvAToNCC4QgAQQxwEQowIQCjoNCC4QsQMQxwEQowIQCjoKCC4QxwEQrwEQCjoKCAAQsQMQyQMQCjoECAAQCkoECEEYAEoECEYYAFAAWIkXYNEZaAJwAXgAgAG_AYgBuQ6SAQQwLjEzmAEAoAEBsAEKwAEB&sclient=gws-wiz";
            $transDolloar = getContents($dollarSource);
            //구글 소스에서 바로 찾아서 넣으면.. 값이 이상하다.
            // 위에서 나온 소스를긇어다가 .. 아래로 적용해야 한다..
            $resultDollar = findStringBetweenAnB($transDolloar,'<span class="qXLe6d epoveb">  <span class="fYyStc">','Canadian Dollar</span>');
            echo $resultDollar;
            // table insert
            $table = $wpdb->prefix."sourceplay_dollor";
            $data = array('won_for_1_dollar' =>  $resultDollar);
            $format = array('%s');
            $wpdb->insert($table, $data, $format);
            exit;
        endif;
    endif;
    // <span class="DFlfde SwHCTb" data-precision="2" data-value="39.007092928949994"></span>
    // <span class="MWvIVe" data-mid="/m/0ptk_" data-name="Canadian Dollar">Canadian Dollar</span>
    // // echo $transDolloar;
}

add_shortcode('sourceplay-dollar', 'shortcode_sourceplay_dollar');
function shortcode_sourceplay_dollar($atts){
    global $wpdb;
    $a = shortcode_atts( array('money' => ''), $atts);
    $base_money = $a['money'];
    $rs = $wpdb->get_row( "select won_for_1_dollar from wp_sourceplay_dollor
    order by insert_date desc limit 1");
    $won_for_1_dollar = str_replace(',', '', $rs->won_for_1_dollar);
    $return_value = number_format(ceil((double)$base_money * (double)$won_for_1_dollar))."원";
    return $return_value;
}

add_action( 'admin_menu', 'change_media_label' );
function change_media_label(){
  global $menu, $submenu;
//   debug_msg($menu);
  $menu[10][0] = 'Photos/Videos';
  $submenu['upload.php'][5][0] = 'All Photos/Videos';
  $submenu['upload.php'][10][0] = 'Upload new';
}

function add_the_theme_page(){
    add_menu_page('Theme page title', 'Theme menu label', 'manage_options', 'theme-options', 'page_content', 'dashicons-book-alt');
}
add_action('admin_menu', 'add_the_theme_page');
function page_content(){
    echo '<div class="wrap"><h2>Testing</h2></div>';
}

// 관리자 메뉴가 실행될때... 후쿠를 걸어줌. 두번째 인자를 실행해라
add_action('admin_menu','source_playground_dollar_menu_setting');
function source_playground_dollar_menu_setting(){
    //관리자 메뉴를 추가함.
    global $_wp_last_object_menu;
    add_menu_page(__('원화환율','source-playground-dollar'), '원화환율계산', 'manage_options', 'source_playgournd_dallar_index', 
    'source_playgournd_dallar_index', 'dashicons-clock');
}
function source_playgournd_dallar_index(){
    // echo "hi ~~~";
    global $wpdb;
    $rate_list = $wpdb->get_results("select d_code, won_for_1_dollar, insert_date 
    from ".$wpdb->prefix."sourceplay_dollor order by insert_date desc");
    include "dollar_rate.php";
}
register_activation_hook(__FILE__, 'source_playground_dollar_activation');
// 활성화시에 작용됨, 
function source_playground_dollar_activation(){
    // 설치작업, 
    // 예를 들어 mysql table 생성해줌.
    // add_option( 'Activated_Plugin', 'Plugin-Slug' );
    // require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $wpdb->query(" CREATE table  `{$wpdb->prefix}sourceplay_dollor` (
        `d_code` int(11) not null auto_increment,
        `won_for_1_dollar` varchar(50) not null,
        `insert_date` datetime not null default current_timestamp,
        primary key(`d_code`)
        );
        ");

}
// 비활성화시 작동됨.
register_deactivation_hook(__FILE__,'source_playground_deactivation');
// 캐시를 없애주거나 옵션정보를 삭제함.
function source_playground_deactivation($networkwid){
// 다시 액티베이션 할수도 있기때문에 테이블 삭제는 안함.
}

register_uninstall_hook(__FILE__, 'source_playground_uninstall');
function source_playground_uninstall(){
    // 테이블 삭제함.
    // 비활성화 상태에서만 후쿠 발생됨.
    // global $wpdb;
    // $wpdb->query("drop table `{$wpdb->prefix}sourceplay_navermap`");
}
?>