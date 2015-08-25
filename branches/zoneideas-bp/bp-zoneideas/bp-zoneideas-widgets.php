<?php

/**
 * In this file you should create and register widgets for your component.
 *
 * Widgets should be small, contained functionality that a site administrator can drop into
 * a widget enabled zone (column, sidebar etc)
 *
 * Good examples of suitable widget functionality would be short lists of updates or featured content.
 *
 * For example the friends and groups components have widgets to show the active, newest and most popular
 * of each.
 */

/**
 * bp_component_register_widgets()
 *
 * This function will register your widgets so that they will show up on the widget list
 * for site administrators to drop into their widget zones.
 */
function bp_zoneideas_register_widgets() {
   global $current_blog;
   
   /* Site welcome widget */
   register_sidebar_widget( __('Cool zoneideas Widget', 'bp-zoneideas'), 'bp_zoneideas_widget_cool_widget');
   register_widget_control( __('Cool zoneideas Widget', 'bp-zoneideas'), 'bp_zoneideas_widget_cool_widget_control' );
   
   /* Include the javascript needed for activated widgets only */
   if ( is_active_widget( 'bp_zoneideas_widget_cool_widget' ) )
      wp_enqueue_script( 'bp_zoneideas_widget_cool_widget-js', site_url( MUPLUGINDIR . '/bp-zoneideas/js/widget-zoneideas.js' ), array('jquery', 'jquery-livequery-pack') );     
}
add_action( 'plugins_loaded', 'bp_zoneideas_register_widgets' );

/**
 * bp_zoneideas_widget_cool_widget()
 *
 * This function controls the actual HTML output of the widget. This is where you will
 * want to query whatever you need, and render the actual output.
 */
function bp_zoneideas_widget_cool_widget($args) {
   global $current_blog, $bp;
   
    extract($args);

   /***
    * This is where you'll want to fetch the widget settings and use them to modify the
    * widget's output.
    */
   $options = get_blog_option( $current_blog->blog_id, 'bp_zoneideas_widget_cool_widget' );
?>
   <?php echo $before_widget; ?>
   <?php echo $before_title
      . $widget_name 
      . $after_title; ?>
      
   <?php
   
   /***
    * This is where you add your HTML and render what you want your widget to display.
    */
   
   ?>
   
   <?php echo $after_widget; ?>
<?php
}

/**
 * bp_zoneideas_widget_cool_widget_control()
 *
 * This function will enable a "edit" menu on your widget. This lets site admins click
 * the edit link on the widget to set options. The options you can then use in the display of 
 * your widget.
 *
 * For zoneideas, in the groups component widget there is a setting called "max-groups" where
 * a user can define how many groups they would like to display.
 */
function bp_zoneideas_widget_cool_widget_control() {
   global $current_blog;
   
   $options = $newoptions = get_blog_option( $current_blog->blog_id, 'bp_zoneideas_widget_cool_widget');

   if ( $_POST['bp-zoneideas-widget-cool-widget'] ) {
      $newoptions['option_name'] = strip_tags( stripslashes( $_POST['bp-zoneideas-widget-cool-widget-option'] ) );
   }
   
   if ( $options != $newoptions ) {
      $options = $newoptions;
      update_blog_option( $current_blog->blog_id, 'bp_zoneideas_widget_cool_widget', $options );
   }

   $option_name = attribute_escape( $options['option_name'] );
?>
   <p><label for="bp-zoneideas-widget-cool-widget-option"><?php _e( 'Some Option', 'bp-zoneideas' ); ?><br /> <input class="widefat" id="bp-zoneideas-widget-cool-widget-option" name="bp-zoneideas-widget-cool-widget-option" type="text" value="<?php echo $option_name; ?>" style="width: 30%" /></label></p>
   <input type="hidden" id="bp-zoneideas-widget-cool-widget" name="bp-zoneideas-widget-cool-widget" value="1" />
<?php
}
