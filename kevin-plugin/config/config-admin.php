<?php
class ConfigAdmin{
    protected $parent_slug;
    protected $page_title;
    protected $menu_title;
    protected $capability;
    protected $menu_slug;

    function __construct($parent_slug)
    {
        $this->parent_slug = $parent_slug;
        $this->page_title="버전 설정";
        $this->menu_title="Version setup";
        $this->capability="manage_options";
        $this->menu_slug="config";
    }

    function register_admin(){
        add_submenu_page(
            $this->parent_slug,
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            array($this,'render_config_admin')
        );

        add_action('admin_init', array($this,'update_version_info'));
    }

    function render_config_admin(){
    ?>
    <h1>앱 버전 설정하기</h1>
    <form method="post" action="options.php">
        <?php settings_fields('version-info-settings'); ?>
        <?php do_settings_sections('version-info-settings'); ?>
        <table class="form-table">
            <tr>
                <th scope="row">현재버전 정보:</th>
                <td><input type="text" name="version_info"
                 value="<?php echo get_option("version_info");?>">
                </td>
            </tr>
            <tr>
                <th scope="row">업데이트 강제하기 여부:</th>
                <td>
                    <input type="radio" name="is_force_update" value="true"
                    <?php if(get_option( 'is_force_update')=="true") echo 'checked';?>>
                    Yes
                    <input type="radio" name="is_force_update" value="false"
                    <?php if(get_option( 'is_force_update')=="false") echo 'checked';?>>
                    No
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
    
    <?php
    }

    function update_version_info(){
        register_setting( "version-info-settings",'version_info');
        register_setting( "version-info-settings",'is_force_update');
    }
}

?>