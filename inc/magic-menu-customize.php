<?php

add_action('customize_register', 'tutormagic_personalized_menu_customize_register');
add_action( 'wp_head', 'tutormagic_personalized_menu_customize_styles');
add_action( 'init', 'tutormagic_personalized_menu_customize_default' );

function tutormagic_personalized_menu_customize_register($wp_customize){

        // Theme Options Panel
        $wp_customize->add_panel( 'tutorlms_appbar_panel', 
            array(
                'title'            => __( 'MightyMenu Tutor LMS', 'mightymenu-tutor' ),
                'description'      => __( 'Dashboard like Menu Modifications can be done here', 'mightymenu-tutor' ),
            ) 
        );

        // Color
        $wp_customize->add_section('tutorlms_appbar_section_color', array(
            'title'         => __('General Color', 'mightymenu-tutor'),
            'description'   => '',
            'priority'      => 1,
            'panel'         => 'tutorlms_appbar_panel'
        ));

        // Layout
        $wp_customize->add_section('tutorlms_appbar_section_layout', array(
            'title'         => __('Layout', 'mightymenu-tutor'),
            'description'   => '',
            'priority'      => 2,
            'panel'         => 'tutorlms_appbar_panel'
        )); 


        // Resume Course Button
        $wp_customize->add_section('tutorlms_appbar_section_resume', array(
            'title'         => __('Resume Course', 'mightymenu-tutor'),
            'description'   => '',
            'priority'      => 4,
            'panel'         => 'tutorlms_appbar_panel'
        ));

        // Menu Items
        $wp_customize->add_section('tutorlms_appbar_section_menu', array(
            'title'         => __('Menu Items', 'mightymenu-tutor'),
            'description'   => '',
            'priority'      => 5,
            'panel'         => 'tutorlms_appbar_panel'
        ));


        // Instructor Info
        $wp_customize->add_section('tutorlms_appbar_section_instructor', array(
            'title'         => __('Instructor Info', 'mightymenu-tutor'),
            'description'   => '',
            'priority'      => 6,
            'panel'         => 'tutorlms_appbar_panel'
        ));

        // Enrolled Courses
        $wp_customize->add_section('tutorlms_appbar_section_course_enrolled', array(
            'title'         => __('Enrolled Courses', 'mightymenu-tutor'),
            'description'   => '',
            'priority'      => 5,
            'panel'         => 'tutorlms_appbar_panel'
        ));


        //  =============================
        //  = Float Position =
        //  =============================
        $wp_customize->add_setting( 'tutor_magin_menu_style_options[float_btn_position]', array(
            'capability'            => 'edit_theme_options',
            'default'               => 'layout_right',
            'type'                  => 'option',
        ) );

        $wp_customize->add_control( 'tutor_magin_menu_style_options[float_btn_position]', array(
              'type'            => 'select',
              'section'         => 'tutorlms_appbar_section_layout',
              'label'           => __('Float Button Position', 'mightymenu-tutor'),
              'settings'        => 'tutor_magin_menu_style_options[float_btn_position]',
              'choices' => array(
                'layout_left' => __( 'Left', 'mightymenu-tutor'),
                'layout_right' => __( 'Right', 'mightymenu-tutor'),
              ),
        )); 

        //  =============================
        //  = Hide on Mobile Devices =
        //  =============================

        $wp_customize->add_setting( 'tutor_magin_menu_style_options[hide_mobile]', array(
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'type'              => 'option',
        ));
     
            $wp_customize->add_control( 'tutor_magin_menu_style_options[hide_mobile]', array(
                'label'         => __('Hide on Mobile Devices', 'mightymenu-tutor'),
                'type'          => 'checkbox',
                'section'       => 'tutorlms_appbar_section_layout',
                'settings'      => 'tutor_magin_menu_style_options[hide_mobile]'
            )); 

        //  =============================
        //  = Text Color =
        //  =============================
            $wp_customize->add_setting('tutor_magin_menu_style_options[tutor_sidebar_text_color]', array(
                'default'           => '#333333',
                'sanitize_callback' => 'sanitize_hex_color',
                'capability'        => 'edit_theme_options',
                'type'              => 'option',
          
            ));
          
            $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tutor_sidebar_text_color', array(
                'label'    => __('Sidebar Text Color', 'mightymenu-tutor'),
                'section'  => 'tutorlms_appbar_section_color',
                'settings' => 'tutor_magin_menu_style_options[tutor_sidebar_text_color]',
            )));

        //  =============================
        //  = Background Color =
        //  =============================
        $wp_customize->add_setting('tutor_magin_menu_style_options[tutor_sidebar_bg_color]', array(
            'default'           => '#f0f2f5',
            'sanitize_callback' => 'sanitize_hex_color',
            'capability'        => 'edit_theme_options',
            'type'              => 'option',
      
        ));
      
        $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tutor_sidebar_bg_color', array(
            'label'    => __('Sidebar Background Color', 'mightymenu-tutor'),
            'section'  => 'tutorlms_appbar_section_color',
            'settings' => 'tutor_magin_menu_style_options[tutor_sidebar_bg_color]',
        )));


        //  =============================
        //  = Resume Button Icon Color =
        //  =============================
        $wp_customize->add_setting('tutor_magin_menu_style_options[resume_btn_color]', array(
            'default'           => '#00897b',
            'sanitize_callback' => 'sanitize_hex_color',
            'capability'        => 'edit_theme_options',
            'type'              => 'option',
      
        ));
      
        $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'resume_btn_color', array(
            'label'    => __('Button Color', 'mightymenu-tutor'),
            'section'  => 'tutorlms_appbar_section_resume',
            'settings' => 'tutor_magin_menu_style_options[resume_btn_color]',
        )));

        //  =============================
        //  = Course Title Color =
        //  =============================
            $wp_customize->add_setting('tutor_magin_menu_style_options[resume_course_title_color]', array(
                'default'           => '#333333',
                'sanitize_callback' => 'sanitize_hex_color',
                'capability'        => 'edit_theme_options',
                'type'              => 'option',
          
            ));
          
            $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'resume_course_title_color', array(
                'label'    => __('Course Title Color', 'mightymenu-tutor'),
                'section'  => 'tutorlms_appbar_section_resume',
                'settings' => 'tutor_magin_menu_style_options[resume_course_title_color]',
            )));    

        //  =============================
        //  = Course Card Color =
        //  =============================
            $wp_customize->add_setting('tutor_magin_menu_style_options[resume_course_bg_color]', array(
                'default'           => '#ffffff',
                'sanitize_callback' => 'sanitize_hex_color',
                'capability'        => 'edit_theme_options',
                'type'              => 'option',
          
            ));
          
            $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'resume_course_bg_color', array(
                'label'    => __('Course Card Color', 'mightymenu-tutor'),
                'section'  => 'tutorlms_appbar_section_resume',
                'settings' => 'tutor_magin_menu_style_options[resume_course_bg_color]',
            ))); 

        //  =============================
        //  = Footer Icons =
        //  =============================
            // Footer Icons Color
            $wp_customize->add_setting('tutor_magin_menu_style_options[footer_icon_color]', 
                array(
                    'default'           => '#333333',
                    'sanitize_callback' => 'sanitize_hex_color',
                    'capability'        => 'edit_theme_options',
                    'type'              => 'option',
                )
            );
          
            $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'footer_icon_color', 
                array(
                    'label'    => __( 'Footer Icons Color', 'mightymenu-tutor' ),
                    'section'  => 'tutorlms_appbar_section_color',
                    'settings' => 'tutor_magin_menu_style_options[footer_icon_color]',
                )
            )); 
}


function tutormagic_personalized_menu_customize_styles(){
        $design_css                     = get_option( 'tutor_magin_menu_style_options');
        $sidebar_bg_color               = isset($design_css['tutor_sidebar_bg_color']) ? $design_css['tutor_sidebar_bg_color'] : "#f0f2f5";
        $sidebar_text_color             = isset($design_css['tutor_sidebar_text_color']) ? $design_css['tutor_sidebar_text_color'] : "#333333";
        $resume_btn_color               = isset($design_css['resume_btn_color']) ? $design_css['resume_btn_color'] : "#00897b";
        $resume_title_color             = isset($design_css['resume_course_title_color']) ? $design_css['resume_course_title_color'] : "#333333";
        $resume_card_color              = isset($design_css['resume_course_bg_color']) ? $design_css['resume_course_bg_color'] : "#ffffff";
        $footer_icon_color              = isset($design_css['footer_icon_color']) ? $design_css['footer_icon_color'] : "#333333";
        ?>
             <style type="text/css">
                :root {
                    --app--sidebar-text: <?php echo sanitize_hex_color( $sidebar_text_color );?>; 
                    --app--sidebar-bg: <?php echo sanitize_hex_color( $sidebar_bg_color );?>;
                    --app--resume-btn-color: <?php echo sanitize_hex_color( $resume_btn_color );?>;
                    --app--resume-btn-light: <?php echo sanitize_hex_color( $resume_btn_color );?>20;
                    --app--footer-icon: <?php echo sanitize_hex_color( $footer_icon_color );?>;
                    --app--resume-card-bg: <?php echo sanitize_hex_color( $resume_card_color );?>;
                    --app--resume-card-title: <?php echo sanitize_hex_color( $resume_title_color );?>;
                    --app--resume-card-title-80: <?php echo sanitize_hex_color( $resume_title_color );?>80;
                    --app--enrolled-bg: <?php echo sanitize_hex_color( $resume_card_color );?>;
                }
             </style>
        <?php
    }


/**
 * Retrieves the default tutor magic menu settings.
 *
 * @return array The default settings.
 */
function tutormagic_personalized_menu_customize_default()
{
    $defaults = [
        'bg_cat_color'                  => '#ffffff',
        'resume_btn_color'              => '#4285f4',
        'resume_course_title_color'     => '#333333',
        'footer_icon_color'             => '#333333',        
        'resume_course_bg_color'        => '#ffffff',
        'text_float_btn_color'          => '#042925',
        'hide_mobile'                   => false,
        'float_btn_position'            => 'layout_right',
    ];

    $options = get_option('tutor_magin_menu_style_options', $defaults);

    return wp_parse_args($options, $defaults);
}
