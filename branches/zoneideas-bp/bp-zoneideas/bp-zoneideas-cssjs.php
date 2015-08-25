<?php

/**
 * You should always use the wp_enqueue_script() and wp_enqueue_style() functions to include
 * javascript and css files.
 */

/**
 * bp_zoneideas_add_js()
 *
 * This function will enqueue the components javascript file, so that you can make
 * use of any javascript you bundle with your component within your interface screens.
 */
function bp_zoneideas_add_js() {
   global $bp;

   if ( $bp->current_component == $bp->zoneideas->slug )
      wp_enqueue_script( 'bp-zoneideas-js', site_url( MUPLUGINDIR . '/bp-zoneideas/js/general.js' ) );
}
add_action( 'template_redirect', 'bp_zoneideas_add_js', 1 );

/**
 * bp_zoneideas_add_structure_css()
 *
 * This function will enqueue structural CSS so that your component will retain interface
 * structure regardless of the theme currently in use. See the notes in the CSS file for more info.
 */
function bp_zoneideas_add_structure_css() {
   /* Enqueue the structure CSS file to give basic positional formatting for your component reglardless of the theme. */
   wp_enqueue_style( 'bp-zoneideas-structure', site_url( MUPLUGINDIR . '/bp-zoneideas/css/structure.css' ) );   
}
add_action( 'bp_styles', 'bp_zoneideas_add_structure_css' );

/**
 * bp_zoneideas_add_activity_bullets_css()
 *
 * This function will allow your component to dynamically add CSS to themes so that you can
 * set the activity feed icon to use for your component.
 */
function bp_zoneideas_add_activity_bullets_css() {
?>
   li a#my-zoneideas, li a#user-zoneideas {
      background: url(<?php echo site_url( MUPLUGINDIR . '/bp-zoneideas/images/heart_bullet.png' ) ?>) 88% 50% no-repeat;
   }

   li.zoneideas {
      background: url(<?php echo site_url( MUPLUGINDIR . '/bp-zoneideas/images/heart_bullet.png' ) ?>) 0 8% no-repeat;
   }

   table#bp-zoneideas-notification-settings th.icon {
      background: url(<?php echo site_url( MUPLUGINDIR . '/bp-zoneideas/images/heart_bullet.png' ) ?>) 50% 50% no-repeat; 
   }
<?php
}
add_action( 'bp_custom_member_styles', 'bp_zoneideas_add_activity_bullets_css' );
add_action( 'bp_custom_home_styles', 'bp_zoneideas_add_activity_bullets_css' );

