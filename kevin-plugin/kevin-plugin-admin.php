<?php

require_once PLUGIN_DIR .'config/config-admin.php';
class KevinPluginAdmin{
    protected $page_title;
    protected $menu_title;
    protected $capability;
    protected $menu_slug;
    protected $position;
    protected $namespace;

    function __construct()
    {
        //멤버필드 초기화
        $this->namespace ="kevin-rest-api";
        $this->page_title="설정";
        $this->menu_title="Kevin-setup";
        $this->menu_slug="app-setting";
        $this->capability="manage_options";
        $this->position="10";
    }

    function admin_main_page(){
        echo "<h1>앱 관련 설정</h1>";
    }

    //어드민을 등록하는 메서드
    function register_admin(){
        // 어드민 메뉴등록
        add_menu_page(
            $this->page_title, //페이지 이름
            $this->menu_title,  //메뉴이름
            $this->capability,  //권한
            $this->menu_slug,  //url 명칭
            array($this, 'admin_main_page'), // 설정페이지 클릭시 콜백
            null,  //ㅑ채ㅜ ㅕ기
            $this->position,
        );
        //서브메뉴 등록
        $this->register_sub_menus();
/*      
        add_menu_page(__('원화환율','source-playground-dollar'), 
        '원화환율계산', 
        'manage_options',
         'source_playgournd_dallar_index', 
        'source_playgournd_dallar_index', 
        'dashicons-clock');
*/
    }
    function register_sub_menus(){
        // 버전 설정 관련 어드민 메뉴 등록
        $config_admin = new ConfigAdmin($this->menu_slug);
        $config_admin->register_admin();
    }
}
?>