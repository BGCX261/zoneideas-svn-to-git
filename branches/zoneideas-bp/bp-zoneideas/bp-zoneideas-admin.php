<?php

/***
 * This file is used to add site administration menus to the WordPress backend.
 *
 * If you need to provide configuration options for your component that can only
 * be modified by a site administrator, this is the best place to do it.
 *
 * However, if your component has settings that need to be configured on a user
 * by user basis - it's best to hook into the front end "Settings" menu.
 */

/**
 * bp_zoneideas_add_admin_menu()
 *
 * Registers the component admin menu into the admin menu array.
 */
function bp_zoneideas_add_admin_menu() {
   global $wpdb, $bp;

   if ( is_site_admin() ) {
      /* Add the administration tab under the "Site Admin" tab for site administrators */
      add_submenu_page( 'wpmu-admin.php', __( 'zoneideas Admin', 'bp-zoneideas' ), __( 'zoneideas Admin', 'bp-zoneideas' ), 1, "bp_zoneideas_settings", "bp_zoneideas_admin" );
   }
}
add_action( 'admin_menu', 'bp_zoneideas_add_admin_menu' );

/**
 * bp_zoneideas_admin()
 *
 * Checks for form submission, saves component settings and outputs admin screen HTML.
 */
function bp_zoneideas_admin() { 
   global $bp, $bbpress_live;
      
   if ( isset( $_POST['submit'] ) ) {
      check_admin_referer('zoneideas-settings');

      update_option( 'zoneideas-setting-one', $_POST['zoneideas-setting-one'] ); 
      update_option( 'zoneideas-setting-two', $_POST['zoneideas-setting-two'] );
      
      $updated = true;
   }
   
   $setting_one = get_option( 'zoneideas-setting-one' );
   $setting_two = get_option( 'zoneideas-setting-two' );
?>
   <div class="wrap">
      <h2><?php _e( 'zoneideas Admin', 'bp-zoneideas' ) ?></h2>
      <br />
      
      <?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bp-zoneideas' ) . "</p></div>" ?><?php endif; ?>
         
      <form action="<?php echo site_url() . '/wp-admin/admin.php?page=bp_zoneideas_settings' ?>" name="zoneideas-settings-form" id="zoneideas-settings-form" method="post">            

         <table class="form-table">
            <tr valign="top">
               <th scope="row"><label for="target_uri"><?php _e( 'Option One', 'bp-zoneideas' ) ?></label></th>
               <td>
                  <input name="zoneideas-setting-one" type="text" id="zoneideas-setting-one" value="<?php echo attribute_escape( $setting_one ); ?>" size="60" />
               </td>
            </tr>
               <th scope="row"><label for="target_uri"><?php _e( 'Option Two', 'bp-zoneideas' ) ?></label></th>
               <td>
                  <input name="zoneideas-setting-two" type="text" id="zoneideas-setting-two" value="<?php echo attribute_escape( $setting_two ); ?>" size="60" />
               </td>
            </tr>
         </table>
         <p class="submit">
            <input type="submit" name="submit" value="<?php _e('Save Settings', 'bp-zoneideas') ?>"/>
         </p>
         
         <?php 
         /* This is very important, don't leave it out. */
         wp_nonce_field( 'zoneideas-settings' );
         ?>
      </form>
   </div>
<?php
}
