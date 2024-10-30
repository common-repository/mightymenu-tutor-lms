<?php
add_action('wp_footer', 'mightymenu_tutor_personalized_sidebar');
add_action('appbar_after_toggle', 'sticky_sidebar_um_tab_output');
add_action('appbar_after_toggle', 'sticky_sidebar_um_footer_menu_output');

/**
 * Outputs personalized sidebar for Tutor LMS.
 * This function outputs a personalized sidebar for Tutor LMS only if the user is logged in and if Tutor LMS is installed.
 * If the current page is of a certain excluded post type, the function will return early and not output the sidebar.
 * The function retrieves various options from the Tutor LMS menu style options and the current user's data.
 * It then generates HTML markup for the personalized sidebar.
 * @return void
 */
function mightymenu_tutor_personalized_sidebar() {
	
    // Check if Tutor LMS is installed and if user is logged in
    if ( ! is_user_logged_in() || ! function_exists( 'tutor_utils' ) ) {
        return;
    }

    // List of post types where the sidebar should not be displayed
    $excluded_post_types = array( 'courses', 'lesson', 'topics', 'tutor_assignments', 'tutor_quiz' );

    // If current page is one of the excluded post types, return early
    if ( is_singular( $excluded_post_types ) ) {
        return;
    }

    // Get Tutor LMS menu style options and set default values
    $settings = get_option( 'tutor_magin_menu_style_options' );
    $hide_mobile = isset( $settings['hide_mobile'] ) ? (bool) $settings['hide_mobile'] : false;
    $hide_class = $hide_mobile ? 'hide-on-mobile' : 'on-mobile';
    $float_btn_position = isset( $settings['float_btn_position'] ) ? $settings['float_btn_position'] : 'layout_right';

    // Get current user's data
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $user_display_name = esc_html( $user->first_name );

    // Get Tutor user data
    $tutor_user = tutor_utils()->get_tutor_user( $user_id );
    $instructor_rating = tutor_utils()->get_instructor_ratings( $user_id );
    $tutor_avatar_url = wp_get_attachment_image_url( $tutor_user->tutor_profile_photo, 'thumbnail' ) ?? get_avatar_url( $user_id );
    $tutor_avatar_url = esc_url( $tutor_avatar_url );

    ?>
    <div class="<?php echo $hide_class; ?> button-toggle-appbar appbar-header-btn-<?php echo esc_attr( $float_btn_position ); ?>" aria-label="Open Menu">
        <div class="appbar-header--toggle">
            <div class="appbar__avatar--toggle">
                <a href="<?php echo esc_url( tutor_utils()->get_tutor_dashboard_page_permalink( 'my-profile' ) ); ?>">
                    <img src="<?php echo $tutor_avatar_url; ?>" alt="<?php echo $user_display_name; ?>">
                </a>
            </div>
            <div class="appbar__name--toggle">
                <h5 class="appbar__username">
                    <a href="<?php echo esc_url( tutor_utils()->get_tutor_dashboard_page_permalink( 'my-profile' ) ); ?>" title="<?php echo esc_attr( $user_display_name ); ?>">
                        <?php echo esc_html( $user_display_name ); ?>
                    </a>
                </h5>
            </div>
            <?php do_action( 'appbar_after_toggle' ); ?>
        </div>
    </div>
    <?php
}

function sticky_sidebar_um_footer_menu_output(){
	?>
	<div class="app-footer">	
		<div class="dark-mode-section" aria-label="Dark Mode" data-balloon-pos="up">
			<a aria-label="Activate dark mode" title="Activate dark mode" class="appbar__dark" role="switch" aria-checked="false">
				<svg class="dark-icon-toggler" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M421.6 379.9c-.6641 0-1.35 .0625-2.049 .1953c-11.24 2.143-22.37 3.17-33.32 3.17c-94.81 0-174.1-77.14-174.1-175.5c0-63.19 33.79-121.3 88.73-152.6c8.467-4.812 6.339-17.66-3.279-19.44c-11.2-2.078-29.53-3.746-40.9-3.746C132.3 31.1 32 132.2 32 256c0 123.6 100.1 224 223.8 224c69.04 0 132.1-31.45 173.8-82.93C435.3 389.1 429.1 379.9 421.6 379.9zM255.8 432C158.9 432 80 353 80 256c0-76.32 48.77-141.4 116.7-165.8C175.2 125 163.2 165.6 163.2 207.8c0 99.44 65.13 183.9 154.9 212.8C298.5 428.1 277.4 432 255.8 432z"/></svg>
			</a>			
		</div>	

		<div class="footer-link-settings">
			<a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink('settings');?>" aria-label="Settings" data-balloon-pos="up">	
				<svg class="appbar-icon-settings" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 416C0 398.3 14.33 384 32 384H86.66C99 355.7 127.2 336 160 336C192.8 336 220.1 355.7 233.3 384H480C497.7 384 512 398.3 512 416C512 433.7 497.7 448 480 448H233.3C220.1 476.3 192.8 496 160 496C127.2 496 99 476.3 86.66 448H32C14.33 448 0 433.7 0 416V416zM192 416C192 398.3 177.7 384 160 384C142.3 384 128 398.3 128 416C128 433.7 142.3 448 160 448C177.7 448 192 433.7 192 416zM352 176C384.8 176 412.1 195.7 425.3 224H480C497.7 224 512 238.3 512 256C512 273.7 497.7 288 480 288H425.3C412.1 316.3 384.8 336 352 336C319.2 336 291 316.3 278.7 288H32C14.33 288 0 273.7 0 256C0 238.3 14.33 224 32 224H278.7C291 195.7 319.2 176 352 176zM384 256C384 238.3 369.7 224 352 224C334.3 224 320 238.3 320 256C320 273.7 334.3 288 352 288C369.7 288 384 273.7 384 256zM480 64C497.7 64 512 78.33 512 96C512 113.7 497.7 128 480 128H265.3C252.1 156.3 224.8 176 192 176C159.2 176 131 156.3 118.7 128H32C14.33 128 0 113.7 0 96C0 78.33 14.33 64 32 64H118.7C131 35.75 159.2 16 192 16C224.8 16 252.1 35.75 265.3 64H480zM160 96C160 113.7 174.3 128 192 128C209.7 128 224 113.7 224 96C224 78.33 209.7 64 192 64C174.3 64 160 78.33 160 96z"/></svg>
			</a>				
		</div>

		<div class="footer-link-logout">
			<a href="<?php echo wp_logout_url( get_permalink() );?>" aria-label="Logout" data-balloon-pos="up">	
				<svg class="appbar-icon-signout" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M160 416H96c-17.67 0-32-14.33-32-32V128c0-17.67 14.33-32 32-32h64c17.67 0 32-14.33 32-32S177.7 32 160 32H96C42.98 32 0 74.98 0 128v256c0 53.02 42.98 96 96 96h64c17.67 0 32-14.33 32-32S177.7 416 160 416zM502.6 233.4l-128-128c-12.51-12.51-32.76-12.49-45.25 0c-12.5 12.5-12.5 32.75 0 45.25L402.8 224H192C174.3 224 160 238.3 160 256s14.31 32 32 32h210.8l-73.38 73.38c-12.5 12.5-12.5 32.75 0 45.25s32.75 12.5 45.25 0l128-128C515.1 266.1 515.1 245.9 502.6 233.4z"/></svg>
			</a>					
		</div>	

		<script type="text/javascript">

		</script>

	</div>
	<?php
}

function sticky_sidebar_um_tab_output(){ 

	$settings = get_option( 'tutor_magin_menu_style_options' );
	?>

<div class="sticky-vertical-tabs">
  <div class="tab-header">

		    <div class="tab-header-icon sidebar-home-menu" aria-label="Home" data-balloon-pos="right">
		      <a href="<?php echo esc_url( home_url( '/' ) );?>">
		      	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
		      </a>
		      <span class="tab-header-icon-title"><?php esc_html_e('Home', 'sticky-sidebar-um');?></span>
		    </div>


	    <div class="tab-header-icon sidebar-course-menu" aria-label="Resume" data-balloon-pos="right">
	      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/></svg>
	      <span class="tab-header-icon-title"><?php esc_html_e('Resume', 'sticky-sidebar-um');?></span>
	    </div>

  </div>

  <div class="tab-content">
    
	    <div class="not-active sidebar-course-content" style="display: none">
	    	<?php dashboard_continue_learning_title();?>
	      <?php mighty_tutor_resume_button();?>
	    </div>

  </div>
</div>

<?php
}


function dashboard_continue_learning_title(){ ?>
	<div class="tab-content-title-section">
	   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/></svg>
			
		<h5 class='tab-content-title'>
				<?php esc_html_e('Resume Learning', 'sticky-sidebar-um');?>
		</h5>
	</div>
	<?php	
}

/**
 * Displays a resume button for enrolled courses.
 * This function retrieves the enrolled courses for the current user and displays a resume button for each course 
 * that has not been completed yet. The button shows the course progress, course title, 
 * and a "Resume" label. It also includes a progress bar that reflects the course completion percentage.
 * @return void
 */
function mighty_tutor_resume_button() {

	// Check if Tutor LMS plugin is active.
    if ( ! function_exists( 'tutor_utils' ) ) {
        return;
    }

    // Retrieve the ID of the current user.
    $current_user_id = get_current_user_id();

    // Get enrolled courses for current user.
    $enrolled_courses_ids = tutor_utils()->get_enrolled_courses_ids_by_user( $current_user_id );

    // Return if user is not enrolled in any course.
    if ( empty( $enrolled_courses_ids ) ) {
        return;
    }
    ?>
    <div class="appbar__resume__container">
        <?php 
        // Loop through each enrolled course and display a resume button if the course has not been completed yet.
        foreach( $enrolled_courses_ids as $enrolled_course_id ) :

        	// Continue if course is already completed.
            if ( tutor_utils()->get_course_completed_percent( $enrolled_course_id, $current_user_id ) == 100 ) {
                continue;
            }

            // Retrieve the course progress, course first lesson URL, and course title.
            $course_progress = tutor_utils()->get_course_completed_percent( $enrolled_course_id, $current_user_id ) . "%";
            $course_first_lesson_url = tutor_utils()->get_course_first_lesson( $enrolled_course_id );
            $course_title = get_the_title( $enrolled_course_id );
        ?>
            <a href="<?php echo esc_url( $course_first_lesson_url ); ?>" class="appbar-resume-course">
                <span class="resume__button--icon" aria-label="<?php echo esc_attr( $course_progress ); ?>" data-balloon-pos="up">
                    <span class="tutor-icon-play-line inline-icon"></span>
                    <span class="resume-label"><?php esc_html_e( 'Resume', 'mightymenu-tutor' ); ?></span>
                    <span class="appbar-course-progress-bar">
                        <span class="appbar-course-progress" style="width:<?php echo esc_attr( $course_progress ); ?>"></span>
                    </span>
                </span>
                <span class="resume__button--info">
                    <span class="resume-course-title"><?php echo esc_html( $course_title ); ?></span>
                    <span class="course-progress-info">
                        <?php echo esc_html( $course_progress ); ?>
                        <?php esc_html_e( 'Completed', 'mightymenu-tutor' ); ?>
                    </span>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}


