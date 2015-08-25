<?php
/*
Plugin Name: ZoneIdeas for BuddyPress
Plugin URI: http://zoneideas.org/bp/
Description: This BuddyPress component implements ZoneIdeas fucntionality.
Author: Serg Podtynnyi
Version: 0.1
Author URI: http://zoneideas.org
*/


/* Require the core component, we'll need to do this straight away so we can make use of core functions. */
require_once( BP_PLUGIN_DIR . '/bp-core.php' );

/* Define a constant that can be checked to see if the component is installed or not. */
define ( 'BP_ZONEIDEAS_IS_INSTALLED', 1 );

/* Define a constant that will hold the current version number of the component */
define ( 'BP_ZONEIDEAS_VERSION', '0.1' );

/* Define a constant that wil hold the database version number that can be used for upgrading the DB */
define ( 'BP_ZONEIDEAS_DB_VERSION', '1' );

/* Define a slug constant that will be used to view this components pages (http://example.org/SLUG) */
define ( 'BP_ZONEIDEAS_SLUG', apply_filters( 'bp_zoneideas_slug', 'ideas' ) );

/**
 * You should try hard to support translation in your component. It's actually very easy.
 * Make sure you wrap any rendered text in __() or _e() and it will then be translatable.
 * 
 * You must also provide a text domain, so translation files know which bits of text to translate.
 * Throughout this example the text domain used is 'bp-example', you can use whatever you want.
 * Put the text domain as the second parameter:
 *
 * __( 'This text will be translatable', 'bp-example' ); // Returns the first parameter value
 * _e( 'This text will be translatable', 'bp-example' ); // Echos the first parameter value
 */
if ( file_exists( MUPLUGINDIR . '/bp-zoneideas/languages/' . get_locale() . '.mo' ) )
   load_textdomain( 'buddypress', MUPLUGINDIR . '/bp-zoneideas/languages/' . get_locale() . '.mo' );


/* The classes file should hold all database access classes and functions */
include_once ( 'bp-zoneideas/bp-zoneideas-classes.php' );

/* The ajax file should hold all functions used in AJAX queries */
include_once ( 'bp-zoneideas/bp-zoneideas-ajax.php' );

/* The cssjs file should set up and enqueue all CSS and JS files used by the component */
include_once ( 'bp-zoneideas/bp-zoneideas-cssjs.php' );

/* The templatetags file should contain classes and functions designed for use in template files */
include_once ( 'bp-zoneideas/bp-zoneideas-templatetags.php' );

/* The widgets file should contain code to create and register widgets for the component */
include_once ( 'bp-zoneideas/bp-zoneideas-widgets.php' );

/* The notifications file should contain functions to send email notifications on specific user actions */
include_once ( 'bp-zoneideas/bp-zoneideas-notifications.php' );

/* The filters file should create and apply filters to component output functions. */
include_once ( 'bp-zoneideas/bp-zoneideas-filters.php' );

/* The admin file should create and manage any WP-admin administration menus for the component */
include_once ( 'bp-zoneideas/bp-zoneideas-admin.php' );

/**
 * bp_zoneideas_install()
 *
 * Installs and/or upgrades the database tables for your component
 */
function bp_zoneideas_install() 
{
   global $wpdb, $bp;
   
   if ( !empty($wpdb->charset) )
      $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
   
   /**
    * You'll need to write your table definition below, if you want to
    * install database tables for your component. You can define multiple
    * tables by adding SQL to the $sql array.
    */
   $sql[] = "CREATE TABLE {$bp->zoneideas->table_name} (
            id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            field_1 bigint(20) NOT NULL,
            field_2 bigint(20) NOT NULL,
            field_3 bool DEFAULT 0,
             KEY field_1 (field_1),
             KEY field_2 (field_2)
            ) {$charset_collate};";

   require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
   
   /**
    * The dbDelta call is commented out so the example table is not installed.
    * Once you define the SQL for your new table, uncomment this line to install
    * the table. (Make sure you increment the BP_EXAMPLE_DB_VERSION constant though).
    */
   //dbDelta($sql);
   
   update_site_option( 'bp-zoneideas-db-version', BP_FRIENDS_DB_VERSION );
}
   
/**
 * bp_zoneideas_setup_globals()
 *
 * Sets up global variables for your component.
 */
function bp_zoneideas_setup_globals() 
{
   global $bp, $wpdb;
   
   $bp->zoneideas->table_name = $wpdb->base_prefix . 'bp_zoneideas';
   $bp->zoneideas->image_base = site_url( MUPLUGINDIR . '/bp-zoneideas/images' );
   $bp->zoneideas->format_activity_function = 'bp_zoneideas_format_activity';
   $bp->zoneideas->format_notification_function = 'bp_zoneideas_format_notifications';
   $bp->zoneideas->slug = BP_ZONEIDEAS_SLUG;

   $bp->version_numbers->zoneideas = BP_ZONEIDEAS_VERSION;
}
add_action( 'wp', 'bp_zoneideas_setup_globals', 1 ); 
add_action( 'admin_menu', 'bp_zoneideas_setup_globals', 1 );


function bp_zoneideas_setup_root_component() {
   /* Register 'ideas' as a root component */
   bp_core_add_root_component( BP_ZONEIDEAS_SLUG );
}
add_action( 'plugins_loaded', 'bp_zoneideas_setup_root_component', 1 );


/**
 * bp_zoneideas_check_installed()
 *
 * Checks to see if the DB tables exist or if you are running an old version
 * of the component. If it matches, it will run the installation function.
 */
function bp_zoneideas_check_installed() 
{   
   global $wpdb, $bp;

   if ( is_site_admin() ) 
   {
      /* Need to check db tables exist, activate hook no-worky in mu-plugins folder. */
      if ( get_site_option('bp-zoneideas-db-version') < BP_zoneideas_DB_VERSION )   bp_zoneideas_install();
   }
}
add_action( 'admin_menu', 'bp_zoneideas_check_installed' );

/**
 * bp_zoneideas_setup_nav()
 *
 * Sets up the navigation items for the component. This adds the top level nav
 * item and all the sub level nav items to the navigation array. This is then
 * rendered in the template.
 */
function bp_zoneideas_setup_nav() 
{
   global $bp;


   
   /* Add 'zoneideas' to the main navigation */
   bp_core_add_nav_item(
      __('Ideas', 'bp-zoneideas'), // The display name
      $bp->zoneideas->slug // The slug
   );
   
   /* Set a specific sub nav item as the default when the top level item is clicked */
   bp_core_add_nav_default( 
      $bp->zoneideas->slug, // The slug of the parent nav item
      'bp_zoneideas_summary', // The function to run when clicked
      'summary' // The slug of the sub nav item to make default
   );
   
   $zoneideas_link = $bp->loggedin_user->domain . $bp->zoneideas->slug . '/';
   

   

      bp_core_add_subnav_item( 
      $bp->zoneideas->slug,'summary',__( 'Summary', 'bp-zoneideas' ),$zoneideas_link, 'bp_zoneideas_summary'
   );

     bp_core_add_subnav_item( 
      $bp->zoneideas->slug,'last',__( 'Last', 'bp-zoneideas' ),$zoneideas_link, 'bp_zoneideas_last_ideas'
   );

     bp_core_add_subnav_item( 
      $bp->zoneideas->slug,'top',__( 'Top', 'bp-zoneideas' ),$zoneideas_link,'bp_zoneideas_top_ideas'
   );

     bp_core_add_subnav_item( 
      $bp->zoneideas->slug,'active',__( 'Active', 'bp-zoneideas' ),$zoneideas_link,'bp_zoneideas_active_ideas'
   );

     bp_core_add_subnav_item( 
      $bp->zoneideas->slug,'new',__( 'New Idea', 'bp-zoneideas' ),$zoneideas_link,'bp_zoneideas_new_idea',
      false, // We don't need to set a custom css ID for this sub nav item.
      bp_is_home() // We DO want to restrict only the logged in user to this sub nav item.
   );


   
   /* Add a nav item for this component under the settings nav item. See bp_zoneideas_screen_settings_menu() for more info */
   bp_core_add_subnav_item( 'settings', 'zoneideas-admin', __( 'zoneideas', 'bp-zoneideas' ), $bp->loggedin_user->domain . 'settings/', 'bp_zoneideas_screen_settings_menu', false, bp_is_home() );  
   
   /* Only execute the following code if we are actually viewing this component (e.g. http://example.org/example) */
   if ( $bp->current_component == $bp->zoneideas->slug ) 
   {

      if ( bp_is_home() ) 
      {
         /* If the user is viewing their own profile area set the title to "My Example" */
         $bp->bp_options_title = __( 'My Ideas', 'bp-zoneideas' );
      } 
      else 
      {
         /* If the user is viewing someone elses profile area, set the title to "[user fullname]" */
         $bp->bp_options_avatar = bp_core_get_avatar( $bp->displayed_user->id, 1 );
         $bp->bp_options_title = $bp->displayed_user->fullname;
      }
   }
}

add_action( 'wp', 'bp_zoneideas_setup_nav', 2 );
add_action( 'admin_menu', 'bp_zoneideas_setup_nav', 2 );


/**
 * The following functions are "Screen" functions. This means that they will be run when their
 * corresponding navigation menu item is clicked, they should therefore pass through to a template
 * file to display output to the user.
 */



function bp_zoneideas_summary()
{
    global $bp;

    
    do_action( 'bp_zoneideas_summary' );
 //   add_action( 'bp_template_content_header', 'bp_zoneideas_summary_header' );
    add_action( 'bp_template_title', 'bp_zoneideas_summary_title' );
    add_action( 'bp_template_content', 'bp_zoneideas_summary_content' );
    bp_core_load_template( 'plugin-template' );

}
   function bp_zoneideas_summary_header() {
      _e('Summary','bp-zoneideas');
   }

   function bp_zoneideas_summary_title() {
      _e('Summary','bp-zoneideas');
   }

   function bp_zoneideas_summary_content()
   {
       global $bp;
       do_action( 'template_notices' ); // (error/success feedback)

   }



function bp_zoneideas_new_idea()
{
    global $bp;

    do_action( 'bp_zoneideas_new_idea' );
    



//    add_action( 'bp_template_content_header', 'bp_zoneideas_new_idea_header' );
    add_action( 'bp_template_title', 'bp_zoneideas_new_idea_title' );
//    add_action( 'bp_template_content', 'bp_zoneideas_screen_one_content' );
    bp_core_load_template( 'plugin-template' );

}
   function bp_zoneideas_new_idea_header() {
      _e('New Idea','bp-zoneideas');
   }

   function bp_zoneideas_new_idea_title() {
      _e('New Idea','bp-zoneideas');
   }


function bp_zoneideas_top_ideas()
{
    global $bp;

    do_action( 'bp_zoneideas_top_ideas' );
    
//    add_action( 'bp_template_content_header', 'bp_zoneideas_top_ideas_header' );
    add_action( 'bp_template_title', 'bp_zoneideas_top_ideas_title' );
//    add_action( 'bp_template_content', 'bp_zoneideas_screen_one_content' );
    bp_core_load_template( 'plugin-template' );

}
   function bp_zoneideas_top_ideas_header() {
      _e('Ideas','bp-zoneideas');
   }

   function bp_zoneideas_top_ideas_title() {
      _e('Top Ideas','bp-zoneideas');
   }

function bp_zoneideas_last_ideas()
{
    global $bp;

    do_action( 'bp_zoneideas_last_ideas' );
    
 //   add_action( 'bp_template_content_header', 'bp_zoneideas_last_ideas_header' );
    add_action( 'bp_template_title', 'bp_zoneideas_last_ideas_title' );
//    add_action( 'bp_template_content', 'bp_zoneideas_screen_one_content' );
    bp_core_load_template( 'plugin-template' );

}
   function bp_zoneideas_last_ideas_header() {
      _e('Ideas','bp-zoneideas');
   }

   function bp_zoneideas_last_ideas_title() {
      _e('Last Ideas','bp-zoneideas');
   }

function bp_zoneideas_active_ideas()
{
    global $bp;

    do_action( 'bp_zoneideas_active_ideas' );
    
//    add_action( 'bp_template_content_header', 'bp_zoneideas_active_ideas_header' );
    add_action( 'bp_template_title', 'bp_zoneideas_active_ideas_title' );
//    add_action( 'bp_template_content', 'bp_zoneideas_screen_one_content' );
    bp_core_load_template( 'plugin-template' );

}
   function bp_zoneideas_active_ideas_header() {
      _e('Active','bp-zoneideas');
   }

   function bp_zoneideas_active_ideas_title() {
      _e('Active Ideas','bp-zoneideas');
   }

/**
 * bp_zoneideas_screen_one()
 *
 * Sets up and displays the screen output for the sub nav item "zoneideas/screen-one"
 */
function bp_zoneideas_screen_one() {
   global $bp;
   
   /**
    * There are three global variables that you should know about and you will 
    * find yourself using often.
    *
    * $bp->current_component (string)
    * This will tell you the current component the user is viewing.
    *  
    * Example: If the user was on the page http://example.org/members/andy/groups/my-groups
    *          $bp->current_component would equal 'groups'.
    *
    * $bp->current_action (string)
    * This will tell you the current action the user is carrying out within a component.
    *  
    * Example: If the user was on the page: http://example.org/members/andy/groups/leave/34
    *          $bp->current_action would equal 'leave'.
    *
    * $bp->action_variables (array)
    * This will tell you which action variables are set for a specific action
    * 
    * Example: If the user was on the page: http://example.org/members/andy/groups/join/34
    *          $bp->action_variables would equal array( '34' );
    */
   
   /**
    * On this screen, as a quick example, users can send you a "High Five", by clicking a link.
    * When a user sends you a high five, you receive a new notification in your
    * notifications menu, and you will also be notified via email.
    */
   
   /**
    * We need to run a check to see if the current user has clicked on the 'send high five' link.
    * If they have, then let's send the five, and redirect back with a nice error/success message.
    */
   if ( $bp->current_component == $bp->zoneideas->slug && 'screen-one' == $bp->current_action && 'send-h5' == $bp->action_variables[0] ) {
      /* The logged in user has clicked on the 'send high five' link */
      if ( bp_is_home() ) {
         /* Don't let users high five themselves */
         bp_core_add_message( __( 'No self-fives! :)', 'bp-zoneideas' ), 'error' );
      } else {
         if ( bp_zoneideas_send_highfive( $bp->displayed_user->id, $bp->loggedin_user->id ) )
            bp_core_add_message( __( 'High-five sent!', 'bp-zoneideas' ) );
         else
            bp_core_add_message( __( 'High-five could not be sent.', 'bp-zoneideas' ), 'error' ); 
      }
      
      bp_core_redirect( $bp->displayed_user->domain . $bp->zoneideas->slug . '/screen-one' );
   }
   
   /* Add a do action here, so your component can be extended by others. */
   do_action( 'bp_zoneideas_screen_one' );
   
   /** 
    * Finally, load the template file. In this example it would load:
    *    "wp-content/member-themes/[active-member-theme]/example/screen-one.php"
    */
    bp_core_load_template( 'zoneideas/screen-one' );
   
   /* ---- OR ----- */
    
   /**
    * However, by loading a template the above way you will need to bundle template files with your component.
    * This is fine for a more complex component, but if your component is simple, you may want to
    * rely on the "plugin-template.php" file bundled with every member theme.
    */
    
    /**
     * To get content into the template file without editing it, we use actions.
     * There are three actions in the template file, the first is for header text where you can
     * place nav items if needed. The second is the page title, and the third is the body content
     * of the page.
     */
    add_action( 'bp_template_content_header', 'bp_zoneideas_screen_one_header' );
    add_action( 'bp_template_title', 'bp_zoneideas_screen_one_title' );
    add_action( 'bp_template_content', 'bp_zoneideas_screen_one_content' );
      
    /* Finally load the plugin template file. */
    bp_core_load_template( 'plugin-template' );
}

   /***
    * The second argument of each of the above add_action() calls is a function that will
    * display the corresponding information. The functions are presented below:
    */

   function bp_zoneideas_screen_one_header() {
      echo 'Screen One Header';
   }

   function bp_zoneideas_screen_one_title() {
      echo 'Screen One';
   }

   function bp_zoneideas_screen_one_content() {
      global $bp;
      
      $high_fives = bp_zoneideas_get_highfives_for_user( $bp->displayed_user->id );
      
      /**
       * For security reasons, we want to use the wp_nonce_url() function on any actions.
       * This will stop naughty people from tricking users into performing actions without their
       * knowledge or intent.
       */
      $send_link = wp_nonce_url( $bp->displayed_user->domain . $bp->current_component . '/screen-one/send-h5', 'bp_zoneideas_send_high_five' );
   ?>
      <?php do_action( 'template_notices' ) // (error/success feedback) ?>
      
      <h3><?php _e( 'Welcome to Screen One', 'bp-zoneideas' ) ?></h3>
      <p><?php printf( __( 'Send %s a <a href="%s" title="Send high-five!">high-five!</a>', 'bp-zoneideas' ), $bp->displayed_user->fullname, $send_link ) ?></p>
      
      <?php if ( $high_fives ) : ?>
         <h3><?php _e( 'Received High Fives!', 'bp-zoneideas' ) ?></h3>
      
         <table id="high-fives">
            <?php foreach ( $high_fives as $user_id ) : ?>
            <tr>
               <td><?php echo bp_core_get_avatar( $user_id, 1, 25, 25 ) ?></td>
               <td>&nbsp; <?php echo bp_core_get_userlink( $user_id ) ?></td>
            </tr>
            <?php endforeach; ?>
         </table>
      <?php endif; ?>
   <?php
   }

/**
 * bp_zoneideas_screen_two()
 *
 * Sets up and displays the screen output for the sub nav item "zoneideas/screen-two"
 */
function bp_zoneideas_screen_two() {
   global $bp;
   
   /** 
    * On the output for this second screen, as an zoneideas, there are terms and conditions with an 
    * "Accept" link (directs to http://zoneideas.org/members/andy/zoneideas/screen-two/accept)
    * and a "Reject" link (directs to http://zoneideas.org/members/andy/zoneideas/screen-two/reject)
    */
   
   if ( $bp->current_component == $bp->zoneideas->slug && 'screen-two' == $bp->current_action && 'accept' == $bp->action_variables[0] ) {
      if ( bp_zoneideas_accept_terms() ) {
         /* Add a success message, that will be displayed in the template on the next page load */
         bp_core_add_message( __( 'Terms were accepted!', 'bp-zoneideas' ) );
      } else {
         /* Add a failure message if there was a problem */
         bp_core_add_message( __( 'Terms could not be accepted.', 'bp-zoneideas' ), 'error' ); 
      }
      
      /**
       * Now redirect back to the page without any actions set, so the user can't carry out actions multiple times
       * just by refreshing the browser.
       */
      bp_core_redirect( $bp->loggedin_user->domain . $bp->current_component );
   }

   if ( $bp->current_component == $bp->zoneideas->slug && 'screen-two' == $bp->current_action && 'reject' == $bp->action_variables[0] ) {
      if ( bp_zoneideas_reject_terms() ) {
         /* Add a success message, that will be displayed in the template on the next page load */
         bp_core_add_message( __( 'Terms were rejected!', 'bp-zoneideas' ) );
      } else {
         /* Add a failure message if there was a problem */
         bp_core_add_message( __( 'Terms could not be rejected.', 'bp-zoneideas' ), 'error' ); 
      }
      
      /**
       * Now redirect back to the page without any actions set, so the user can't carry out actions multiple times
       * just by refreshing the browser.
       */
      bp_core_redirect( $bp->loggedin_user->domain . $bp->current_component );
   }
   
   /** 
    * If the user has not Accepted or Rejected anything, then the code above will not run,
    * we can continue and load the template.
    */
         
   do_action( 'bp_zoneideas_screen_two' );
   
   add_action( 'bp_template_content_header', 'bp_zoneideas_screen_two_header' );
   add_action( 'bp_template_title', 'bp_zoneideas_screen_two_title' );
   add_action( 'bp_template_content', 'bp_zoneideas_screen_two_content' );
      
   /* Finally load the plugin template file. */
   bp_core_load_template( 'plugin-template' );
}

   function bp_zoneideas_screen_two_header() {
      echo 'Screen Two Header';
   }

   function bp_zoneideas_screen_two_title() {
      echo 'Screen Two';
   }

   function bp_zoneideas_screen_two_content() {
      global $bp; ?>
      
      <?php do_action( 'template_notices' ) ?>
      
      <h4><?php _e( 'Welcome to Screen Two', 'bp-zoneideas' ) ?></h4>
      
      <?php
         $accept_link = '<a href="' . wp_nonce_url( $bp->loggedin_user->domain . $bp->zoneideas->slug . '/screen-two/accept', 'bp_zoneideas_accept_terms' ) . '">' . __( 'Accept', 'bp-zoneideas' ) . '</a>';
         $reject_link = '<a href="' . wp_nonce_url( $bp->loggedin_user->domain . $bp->zoneideas->slug . '/screen-two/reject', 'bp_zoneideas_reject_terms' ) . '">' . __( 'Reject', 'bp-zoneideas' ) . '</a>';
      ?>
      
      <p><?php printf( __( 'You must %s or %s the terms of use policy.', 'bp-zoneideas' ), $accept_link, $reject_link ) ?></p>
   <?php
   }
   
function bp_zoneideas_screen_settings_menu() {
   global $bp, $current_user, $bp_settings_updated, $pass_error;

   if ( isset( $_POST['submit'] ) && check_admin_referer('bp-zoneideas-admin') ) {
      $bp_settings_updated = true;

      /** 
       * This is when the user has hit the save button on their settings. 
       * The best place to store these settings is in wp_usermeta. 
       */
      update_usermeta( $bp->loggedin_user->id, 'bp-zoneideas-option-one', attribute_escape( $_POST['bp-zoneideas-option-one'] ) );   
   }

   add_action( 'bp_template_content_header', 'bp_zoneideas_screen_settings_menu_header' );
   add_action( 'bp_template_title', 'bp_zoneideas_screen_settings_menu_title' );
   add_action( 'bp_template_content', 'bp_zoneideas_screen_settings_menu_content' );

   bp_core_load_template('plugin-template');
}

   function bp_zoneideas_screen_settings_menu_header() {
      _e( 'zoneideas Settings Header', 'bp-zoneideas' );
   }

   function bp_zoneideas_screen_settings_menu_title() {
      _e( 'zoneideas Settings', 'bp-zoneideas' );
   }

   function bp_zoneideas_screen_settings_menu_content() {
      global $bp, $bp_settings_updated; ?>

      <?php if ( $bp_settings_updated ) { ?>
         <div id="message" class="updated fade">
            <p><?php _e( 'Changes Saved.', 'bp-zoneideas' ) ?></p>
         </div>
      <?php } ?>
      
      <form action="<?php echo $bp->loggedin_user->domain . 'settings/zoneideas-admin'; ?>" name="bp-zoneideas-admin-form" id="account-delete-form" class="bp-zoneideas-admin-form" method="post">

         <input type="checkbox" name="bp-zoneideas-option-one" id="bp-zoneideas-option-one" value="1"<?php if ( '1' == get_usermeta( $bp->loggedin_user->id, 'bp-zoneideas-option-one' ) ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Do you love clicking checkboxes?', 'bp-zoneideas' ); ?>
         <p class="submit">
            <input type="submit" value="<?php _e( 'Save Settings', 'bp-zoneideas' ) ?> &raquo;" id="submit" name="submit" />
         </p>

         <?php 
         /* This is very important, don't leave it out. */
         wp_nonce_field( 'bp-zoneideas-admin' );
         ?>

      </form>
   <?php
   }


/**
 * bp_zoneideas_screen_notification_settings()
 *
 * Adds notification settings for the component, so that a user can turn off email
 * notifications set on specific component actions.
 */
function bp_zoneideas_screen_notification_settings() { 
   global $current_user;
   
   /**
    * Under Settings > Notifications within a users profile page they will see
    * settings to turn off notifications for each component.
    * 
    * You can plug your custom notification settings into this page, so that when your
    * component is active, the user will see options to turn off notifications that are
    * specific to your component.
    */
   
    /**
     * Each option is stored in a posted array notifications[SETTING_NAME]
     * When saved, the SETTING_NAME is stored as usermeta for that user.
     *
     * For zoneideas, notifications[notification_friends_friendship_accepted] could be
     * used like this:
     * 
     * if ( 'no' == get_usermeta( $bp['loggedin_userid], 'notification_friends_friendship_accepted' ) )
     *      // don't send the email notification
     *   else
     *      // send the email notification.
      */

   ?>
   <table class="notification-settings" id="bp-zoneideas-notification-settings">
      <tr>
         <th class="icon"></th>
         <th class="title"><?php _e( 'zoneideas', 'bp-zoneideas' ) ?></th>
         <th class="yes"><?php _e( 'Yes', 'bp-zoneideas' ) ?></th>
         <th class="no"><?php _e( 'No', 'bp-zoneideas' )?></th>
      </tr>
      <tr>
         <td></td>
         <td><?php _e( 'Action One', 'bp-zoneideas' ) ?></td>
         <td class="yes"><input type="radio" name="notifications[notification_zoneideas_action_one]" value="yes" <?php if ( !get_usermeta( $current_user->id,'notification_zoneideas_action_one') || 'yes' == get_usermeta( $current_user->id,'notification_zoneideas_action_one') ) { ?>checked="checked" <?php } ?>/></td>
         <td class="no"><input type="radio" name="notifications[notification_zoneideas_action_one]" value="no" <?php if ( get_usermeta( $current_user->id,'notification_zoneideas_action_one') == 'no' ) { ?>checked="checked" <?php } ?>/></td>
      </tr>
      <tr>
         <td></td>
         <td><?php _e( 'Action Two', 'bp-zoneideas' ) ?></td>
         <td class="yes"><input type="radio" name="notifications[notification_zoneideas_action_two]" value="yes" <?php if ( !get_usermeta( $current_user->id,'notification_zoneideas_action_two') || 'yes' == get_usermeta( $current_user->id,'notification_zoneideas_action_two') ) { ?>checked="checked" <?php } ?>/></td>
         <td class="no"><input type="radio" name="notifications[notification_zoneideas_action_two]" value="no" <?php if ( 'no' == get_usermeta( $current_user->id,'notification_zoneideas_action_two') ) { ?>checked="checked" <?php } ?>/></td>
      </tr>
      
      <?php do_action( 'bp_zoneideas_notification_settings' ); ?>
   </table>
<?php 
}
add_action( 'bp_notification_settings', 'bp_zoneideas_screen_notification_settings' );

/**
 * bp_zoneideas_record_activity()
 *
 * If the activity stream component is installed, this function will record activity items for your
 * component.
 *
 * You must pass the function an associated array of arguments:
 *
 *     $args = array( 
 *       'item_id' => The ID of the main piece of data being recorded, for zoneideas a group_id, user_id, forum_post_id
 *       'component_name' => The slug of the component.
 *       'component_action' => The action being carried out, for zoneideas 'new_friendship', 'joined_group'. You will use this to format activity.
 *     'is_private' => Boolean. Should this not be shown publicly?
 *       'user_id' => The user_id of the person you are recording this activity stream item for.
 *     'secondary_item_id' => (optional) If the activity is more complex you may need a second ID. For zoneideas a group forum post needs the group_id AND the forum_post_id.
 *       'secondary_user_id' => (optional) If this activity applies to two users, provide the second user_id. Eg, Andy and John are now friends should show on both users streams
 *     )
 */
function bp_zoneideas_record_activity( $args ) {
   if ( function_exists('bp_activity_record') ) {
      extract( (array)$args );
      bp_activity_record( $item_id, $component_name, $component_action, $is_private, $secondary_item_id, $user_id, $secondary_user_id );
   }
}

/**
 * bp_zoneideas_delete_activity()
 *
 * If the activity stream component is installed, this function will delete activity items for your
 * component.
 *
 * You should use this when items are deleted, to keep the activity stream in sync. For zoneideas if a user
 * publishes a new blog post, it would record it in the activity stream. However, if they then make it private
 * or they delete it. You'll want to remove it from the activity stream, otherwise you will get out of sync and
 * bad links.
 */
function bp_zoneideas_delete_activity( $args ) {
   if ( function_exists('bp_activity_delete') ) {
      extract( (array)$args );
      bp_activity_delete( $item_id, $component_name, $component_action, $user_id, $secondary_item_id );
   }
}

/**
 * bp_zoneideas_format_activity()
 *
 * Formatting your activity items is the other important step in adding your custom component activity into
 * activity streams.
 *
 * The bp_zoneideas_record_activity() function simply records ID's that are needed to fetch information about
 * the activity. The bp_zoneideas_format_activity() will take those ID's and make something that is human readable.
 *
 * You'll notice in the function bp_zoneideas_setup_globals() we set up a global called 'format_activity_function'.
 * This is the function name that the activity component will look at to format your component's activity when needed.
 * 
 * This is where the 'component_action' variable set in bp_zoneideas_record_activity() comes into play. For each
 * one of those actions, you will need to define how that activity action is rendered.
 * 
 * You do not have to call this function anywhere, or pass any parameters, the activity component will handle it.
 */
function bp_zoneideas_format_activity( $item_id, $user_id, $action, $secondary_item_id = false, $for_secondary_user = false ) {
   global $bp;
   
   /* $action is the 'component_action' variable set in the record function. */
   switch( $action ) {
      case 'accepted_terms':
         /* In this case, $item_id is the user ID of the user who accepted the terms. */
         $user_link = bp_core_get_userlink( $item_id );
         
         if ( !$user_link )
            return false;
         
         /***
          * We return activity items as an array. The 'primary_link' is for RSS feeds, so when the reader clicks
          * a new item header, it will go to this link (sometimes there is more than one link in an activity item).
          */
         return array( 
            'primary_link' => $user_link,
            'content' => apply_filters( 'bp_zoneideas_accepted_terms_activity', sprintf( __('%s accepted the really exciting terms and conditions!', 'bp-zoneideas'), $user_link ) . ' <span class="time-since">%s</span>', $user_link )
         );          
      break;
      case 'rejected_terms':
         $user_link = bp_core_get_userlink( $item_id );
         
         if ( !$user_link )
            return false;

         return array( 
            'primary_link' => $user_link,
            'content' => apply_filters( 'bp_zoneideas_rejected_terms_activity', sprintf( __('%s rejected the really exciting terms and conditions.', 'bp-zoneideas'), $user_link ) . ' <span class="time-since">%s</span>', $user_link )
         );          
      break;
      case 'new_high_five':
         /* In this case, $item_id is the user ID of the user who recieved the high five. */
         $to_user_link = bp_core_get_userlink( $item_id );
         $from_user_link = bp_core_get_userlink( $user_id );
         
         if ( !$to_user_link || !$from_user_link )
            return false;

         return array( 
            'primary_link' => $to_user_link,
            'content' => apply_filters( 'bp_zoneideas_new_high_five_activity', sprintf( __('%s high-fived %s!', 'bp-zoneideas'), $from_user_link, $to_user_link ) . ' <span class="time-since">%s</span>', $from_user_link, $to_user_link )
         );          
      break;
   }
   
   /* By adding a do_action here, people can extend your component with new activity items. */
   do_action( 'bp_zoneideas_format_activity', $action, $item_id, $user_id, $action, $secondary_item_id, $for_secondary_user );
   
   return false;
}

/**
 * bp_zoneideas_format_notifications()
 *
 * Formatting notifications works in very much the same way as formatting activity items.
 * 
 * These notifications are "screen" notifications, that is, they appear on the notifications menu
 * in the site wide navigation bar. They are not for email notifications.
 *
 * You do not need to make a specific notification recording function for your component because the 
 * notification recorded functions are bundled in the core, which is required.
 *
 * The recording is done by using bp_core_add_notification() which you can search for in this file for
 * zoneideass of usage.
 */
function bp_zoneideas_format_notifications( $action, $item_id, $secondary_item_id, $total_items ) {
   global $bp;

   switch ( $action ) {
      case 'new_high_five':
         /* In this case, $item_id is the user ID of the user who sent the high five. */
         
         /***
          * We don't want a whole list of similar notifications in a users list, so we group them.
          * If the user has more than one action from the same component, they are counted and the
          * notification is rendered differently.
          */
         if ( (int)$total_items > 1 ) {
            return apply_filters( 'bp_zoneideas_multiple_new_high_five_notification', '<a href="' . $bp->loggedin_user->domain . $bp->zoneideas->slug . '/screen-one/" title="' . __( 'Multiple high-fives', 'bp-zoneideas' ) . '">' . sprintf( __('%d new high-fives, multi-five!'), (int)$total_items ) . '</a>', $total_items );    
         } else {
            $user_fullname = bp_fetch_user_fullname( $item_id, false );
            $user_url = bp_core_get_userurl( $item_id );
            return apply_filters( 'bp_zoneideas_single_new_high_five_notification', '<a href="' . $user_url . '?new" title="' . $user_fullname .'\'s profile">' . sprintf( __( '%s sent you a high-five!', 'bp-zoneideas' ), $user_fullname ) . '</a>', $user_fullname );
         }  
      break;
   }

   do_action( 'bp_zoneideas_format_notifications', $action, $item_id, $secondary_item_id, $total_items );
   
   return false;
}


/***
 * From now on you will want to add your own functions that are specific to the component you are developing.
 * For zoneideas, in this section in the friends component, there would be functions like:
 *    friends_add_friend()
 *    friends_remove_friend()
 *    friends_check_friendship()
 *
 * Some guidelines:
 *    - Don't set up error messages in these functions, just return false if you hit a problem and
 *    deal with error messages in screen or action functions.
 *    
 *    - Don't directly query the database in any of these functions. Use database access classes
 *       or functions in your bp-zoneideas-classes.php file to fetch what you need. Spraying database 
 *       access all over your plugin turns into a maintainence nightmare, trust me.
 *
 *   - Try to include add_action() functions within all of these functions. That way others will find it
 *    easy to extend your component without hacking it to pieces.
 */

/**
 * bp_zoneideas_accept_terms()
 *
 * Accepts the terms and conditions screen for the logged in user.
 * Records an activity stream item for the user.
 */
function bp_zoneideas_accept_terms() {
   global $bp;
   
   /**
    * First check the nonce to make sure that the user has initiated this
    * action. Remember the wp_nonce_url() call? The second parameter is what
    * you need to check for.
    */
   if ( !check_admin_referer( 'bp_zoneideas_accept_terms' ) ) 
      return false;

   /***
    * Here is a good zoneideas of where we can post something to a users activity stream.
    * The user has excepted the terms on screen two, and now we want to post
    * "Andy accepted the really exciting terms and conditions!" to the stream.
    */
   
   bp_zoneideas_record_activity( 
      array( 
         'item_id' => $bp->loggedin_user->id,
         'user_id' => $bp->loggedin_user->id,
         'component_name' => $bp->zoneideas->slug, 
         'component_action' => 'accepted_terms', 
         'is_private' => 0
      )
   );
   
   /* See bp_zoneideas_reject_terms() for an explanation of deleting activity items */
   bp_zoneideas_delete_activity( 
      array( 
         'item_id' => $bp->loggedin_user->id,
         'user_id' => $bp->loggedin_user->id,
         'component_name' => $bp->zoneideas->slug,
         'component_action' => 'rejected_terms'
      )
   );
   
   /***
    * Remember, even though we have recorded the activity, we still need to tell
    * the activity component how to format that activity item into something readable.
    * In the bp_zoneideas_format_activity() function, we need to make an entry for
    * 'accepted_terms'
    */
   
   /* Add a do_action here so other plugins can hook in */
   do_action( 'bp_zoneideas_accept_terms', $bp->loggedin_user->id );

   /***
    * You'd want to do something here, like set a flag in the database, or set usermeta.
    * just for the sake of the demo we're going to return true.
    */

   return true;
}

/**
 * bp_zoneideas_reject_terms()
 *
 * Rejects the terms and conditions screen for the logged in user.
 * Records an activity stream item for the user.
 */
function bp_zoneideas_reject_terms() {
   global $bp;
   
   if ( !check_admin_referer( 'bp_zoneideas_reject_terms' ) ) 
      return false;
   
   /***
    * In this zoneideas component, the user can reject the terms even after they have
    * previously accepted them.
    * 
    * If a user has accepted the terms previously, then this will be in their activity
    * stream. We don't want both 'accepted' and 'rejected' in the activity stream, so
    * we should remove references to the user accepting from all activity streams.
    * A real world zoneideas of this would be a user deleting a published blog post.
    */
   
   /* Delete any accepted_terms activity items for the user */
   bp_zoneideas_delete_activity( 
      array( 
         'item_id' => $bp->loggedin_user->id,
         'user_id' => $bp->loggedin_user->id,
         'component_name' => $bp->zoneideas->slug,
         'component_action' => 'accepted_terms'
      )
   );
   
   /* Now record the new 'rejected' activity item */
   bp_zoneideas_record_activity( 
      array( 
         'item_id' => $bp->loggedin_user->id,
         'user_id' => $bp->loggedin_user->id,
         'component_name' => $bp->zoneideas->slug, 
         'component_action' => 'rejected_terms', 
         'is_private' => 0
      )
   );

   do_action( 'bp_zoneideas_reject_terms', $bp->loggedin_user->id );
   
   return true;
}

/**
 * bp_zoneideas_send_high_five()
 *
 * Sends a high five message to a user. Registers an notification to the user
 * via their notifications menu, as well as sends an email to the user.
 *
 * Also records an activity stream item saying "User 1 high-fived User 2".
 */
function bp_zoneideas_send_highfive( $to_user_id, $from_user_id ) {
   global $bp;
   
   if ( !check_admin_referer( 'bp_zoneideas_send_high_five' ) ) 
      return false;
   
   /**
    * We'll store high-fives as usermeta, so we don't actually need
    * to do any database querying. If we did, and we were storing them
    * in a custom DB table, we'd want to reference a function in
    * bp-zoneideas-classes.php that would run the SQL query.
    */
   
   /* Get existing fives */
   $existing_fives = maybe_unserialize( get_usermeta( $to_user_id, 'high-fives' ) );
   
   /* Check to see if the user has already high-fived. That's okay, but lets not
    * store duplicate high-fives in the database. What's the point, right?
    */
   if ( !in_array( $from_user_id, (array)$existing_fives ) ) {
      $existing_fives[] = (int)$from_user_id;
      
      /* Now wrap it up and fire it back to the database overlords. */
      update_usermeta( $to_user_id, 'high-fives', serialize( $existing_fives ) );
   }
   
   /***
    * Now we've registered the new high-five, lets work on some notification and activity
    * stream magic. 
    */
   
   /***
    * Post a screen notification to the user's notifications menu.
    * Remember, like activity streams we need to tell the activity stream component how to format
    * this notification in bp_zoneideas_format_notifications() using the 'new_high_five' action.
    */
   bp_core_add_notification( $from_user_id, $to_user_id, $bp->zoneideas->slug, 'new_high_five' );

   /* Now record the new 'new_high_five' activity item */
   bp_zoneideas_record_activity( 
      array( 
         'item_id' => $to_user_id,
         'user_id' => $from_user_id,
         'component_name' => $bp->zoneideas->slug, 
         'component_action' => 'new_high_five', 
         'is_private' => 0
      )
   );

   /* We'll use this do_action call to send the email notification. See bp-zoneideas-notifications.php */
   do_action( 'bp_zoneideas_send_high_five', $to_user_id, $from_user_id );
   
   return true;
}

/**
 * bp_zoneideas_get_highfives_for_user()
 *
 * Returns an array of user ID's for users who have high fived the user passed to the function.
 */
function bp_zoneideas_get_highfives_for_user( $user_id ) {
   global $bp;
   
   if ( !$user_id )
      return false;
   
   return maybe_unserialize( get_usermeta( $user_id, 'high-fives' ) );
}

/**
 * 
 */
function bp_zoneideas_remove_screen_notifications() {
   global $bp;
   
   /**
    * When clicking on a screen notification, we need to remove it from the menu.
    * The following command will do so.
    */
   bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->zoneideas->slug, 'new_high_five' );
}
add_action( 'bp_zoneideas_screen_one', 'bp_zoneideas_remove_screen_notifications' );
add_action( 'xprofile_screen_display_profile', 'bp_zoneideas_remove_screen_notifications' );

/**
 * bp_zoneideas_remove_data()
 *
 * It's always wise to clean up after a user is deleted. This stops the database from filling up with
 * redundant information.
 */
function bp_zoneideas_remove_data( $user_id ) {
   /* You'll want to run a function here that will delete all information from any component tables
      for this $user_id */
   
   /* Remember to remove usermeta for this component for the user being deleted */
   delete_usermeta( $user_id, 'bp_zoneideas_some_setting' );

   do_action( 'bp_zoneideas_remove_data', $user_id );
}
add_action( 'wpmu_delete_user', 'bp_zoneideas_remove_data', 1 );
add_action( 'delete_user', 'bp_zoneideas_remove_data', 1 );


?>