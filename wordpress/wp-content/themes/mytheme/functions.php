<?php

    function learningWordPress_resources() {
        
        wp_enqueue_style('style', get_stylesheet_uri());
        
    }
    
    add_action('wp_enqueue_scripts','learningWordPress_resources');
    
    //navigation menu
    
    
    
    function get_top_ancestor_id() {
        global $post;
        
        if($post->post_parent) {
            $ancestors = array_reverse(get_post_ancestors($post->ID));
            return $ancestors[0];
        } else {
            return $post->ID;
        }
    }
    
    function has_children() {
        
        global $post;
        
        $pages = get_pages('child_of=' . $post->ID);
        return count($pages);
    }
    
    function custom_excerpt_length() {
        return 25;
    }
    
    add_filter('excerpt_length','custom_excerpt_length');
    
    function learningWordPress_setup() {
        
        register_nav_menus(array(
        'primary'=>__('Primary Menu'),
        'footer'=>__('Footer Menu'),
        ));
        
        add_theme_support('post-thumbnails');
        add_image_size('small-thumbnails',180,120,true);
        add_image_size('banner-image',920,210,true);
        
        add_theme_support('post-formats',array('aside','link','gallery'));
    }
    add_action('after_setup_theme','learningWordPress_setup');
    
    
    //add our widget locations
    
    function ourWidgetsInit() {
        register_sidebar(array(
            'name' => 'Sidebar',
            'id' => 'sidebar1',
            'before_widget' => '<div class="widget-item">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="my-special-class">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
        'name' => 'footer area1',
        'id' => 'footer1',
        ));
        register_sidebar(array(
        'name' => 'footer area2',
        'id' => 'footer2',
        ));
        register_sidebar(array(
        'name' => 'footer area3',
        'id' => 'footer3',
        ));
        register_sidebar(array(
        'name' => 'footer area4',
        'id' => 'footer4',
        ));
    }
    add_action('widgets_init','ourWidgetsInit');
    
    
    function learningWordPress_customize_register($wp_customize) {
        $wp_customize -> add_setting('lwp_link_color',array(
            'default' => '#006ec3',
            'transport' => 'refresh',
        ));
        
        $wp_customize -> add_setting('lwp_btn_color',array(
            'default' => '#006ec3',
            'transport' => 'refresh',
        ));
        
        $wp_customize -> add_section('lwp_standard_colors',array(
            'title' => __('Standard Colors','LearningWordPress'),
            'priority' => 30,
        ));
        
        $wp_customize -> add_control(new WP_Customize_Color_Control($wp_customize,'lwp_link_color_control',array(
            'label' => __('Link Color','LearningWordPress'),
            'section' => 'lwp_standard_colors',
            'settings' => 'lwp_link_color',
        )));
        
        $wp_customize -> add_control(new WP_Customize_Color_Control($wp_customize,'lwp_btn_color_control',array(
            'label' => __('Btn Color','LearningWordPress'),
            'section' => 'lwp_standard_colors',
            'settings' => 'lwp_btn_color',
        )));
        
    }
    
    add_action('customize_register','learningWordPress_customize_register');
    
    function learningWordPress_customize_css() { ?>

        <style type="text/css">

            a:link,
            a:visited {
	           color: <?php echo get_theme_mod('lwp_link_color'); ?>
            }
    
            .site_header nav ul li.current-menu-item a:link,
            .site_header nav ul li.current-menu-item a:visited, 
            .site_header nav ul li.current-page-ancestor a:link,
            .site_header nav ul li.current-page-ancestor a:visited {
                background-color: <?php echo get_theme_mod('lwp_link_color'); ?>
            }
       
            .btn-a,
            .btn-a:link,
            .btn-a:visited {
                background-color: <?php echo get_theme_mod('lwp_btn_color'); ?>
            } 
            div.hd-search #searchsubmit {
                background-color: <?php echo get_theme_mod('lwp_btn_color'); ?>
            }                
         </style>
    
    <?php 
    }
    
    add_action('wp_head','learningWordPress_customize_css');
    
    