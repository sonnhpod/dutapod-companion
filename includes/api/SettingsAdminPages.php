<?php
/*
 * @package Sunsetpro
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace DutapodCompanion\Includes\Api;

class SettingsAdminPages{

    /** 1. Variable declarations */
    // 1.1. WordPress admin setting pages and sub pages
    public array $adminPages;
    public array $adminSubPages;

    // 1.2. WordPress admin settings, sections, and fields 
    // - Use for all admin pages & sub pages?
    public array $settings;
    public array $sections;
    public array $fields;

    /** 2. Constructor */
    public function __construct(){
        $this->adminPages = array();
        $this->adminSubPages = array();

        $this->settings = array();
        $this->sections = array();
        $this->fields = array();

    }//__construct

    /** 3. Operational functions */
    /** 3.1. Main operational function for plugin operation. */
    public function register(){
        /* 1. Register if the admin page or admin subpages are not empty
        * - This register method will be called in different locations.
        * */
        if( !empty($this->adminPages || !empty($this->adminSubPages) ) ){
            add_action( 'admin_menu', array( $this, 'addToWpAdminMenu' ) );
        }
    
        if( !empty($this->settings) ){
            add_action( 'admin_init', array($this, 'registerCustomFields') );
        }

        // return $this;
    }//register

    /** 3.1 - helper functions for register method () */
    /** 3.1.1. Add to WordPress admin setting page menu */
    public function addToWpAdminMenu(){

        // 1. Add all "main (parent) admin setting page" to the WP admin setting page's menu:
        foreach( $this->adminPages as $page ){
            add_menu_page(
                $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'],
                $page['callback'], $page['icon_url'],$page['position']
            );
        }// endforeach
    
        // 2. Add all "sub - admin setting page" to the main (parent) admin setting page above - at the WP admin setting page's menu:
        foreach( $this->adminSubPages as $page ){
            add_submenu_page(
                $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'],
                $page['menu_slug'], $page['callback']
            );
        }// endforeach

        return $this;
    }//addToWpAdminMenu

    /** 3.1.2. Add to WordPress admin setting page menu */
    public function registerCustomFields(){
        /* 1. Register fields . Total 20 custom fields to handle users activities (even more)
        $setting['callback'] ?? '') ~ isset(setting['callback']) ? setting['callback] : ''; */
        // 1.1. Register setting
        foreach($this->settings as $setting){
            register_setting( 
                $setting['option_group'], $setting['option_name'], ($setting['callback'] ?? '') 
            );
        }
    
        // 1.2. Add settings section
        foreach($this->sections as $section){
            add_settings_section(
                $section['id'], $section['title'], ($section['callback'] ?? ''), $section['page']
            );
        }
        // 1.3. Add settings field
        foreach($this->fields as $field){
          add_settings_field(
            $field['id'], $field['title'], ($field['callback'] ?? ''), $field['page'],
            $field['section'], ($field['args'] ?? '')
        );
        }    

        return $this;
    }//registerCustomFields


    /** 3.2. Set class properties functions. 
     * - This would be called before register() method.
     * - "return $this" to apply chain method invocation */
    
    /* Add admin pages ~ method addPages in tutorials */
    public function addAdminPages( array $pages ): static {
        $this->adminPages = $pages;

        return $this;
    }//addAdminPages

    public function withSubPage( string $title = null ): static {
        if( empty($this->adminPages) ){
          return $this;
        }
        // The 1st item in $this->admin_pages is parent page
        // Grab the parent page/root page
        $admin_page = $this->adminPages[0];
    
        /*
        * The parent_slug of a sub page must be menu_slug of admin page
        **/
        $sub_pages = array(
            array(
                'parent_slug'     => $admin_page['menu_slug'],
                'page_title'      => $admin_page['page_title'],
                'menu_title'      => ($title) ? $title : $admin_page['menu_title'],
                'capability'      => $admin_page['capability'],
                'menu_slug'       => $admin_page['menu_slug'],
                'callback'        => function(){echo '<h3> dutapod-companion plugin sub pages </h3>';},
            ),
        );
    
        $this->adminSubPages = $sub_pages;
    
        return $this;
    }//withSubPage  

    public function addSubPages( array $pages ) : static{
        // Update the subpages
        // $this->admin_subpages = $pages;
        $this->adminSubPages = array_merge( $this->adminSubPages, $pages );
    
        return $this;
    }//addSubPages
    
    public function setSettings( array $settings ): static
    {
        $this->settings = $settings;

        return $this;
    }//setSettings

    public function setSections( array $sections ): static {
        $this->sections = $sections;

        return $this;
    }//setSections

    public function setFields( array $fields ) : static {
        $this->fields = $fields;

        return $this;
    }//setFields

    
}//End of class SettingsAdminPages declarations
