<?php

/**
 * In this file you should define template tag functions that end users can add to their template files.
 * Each template tag function should echo the final data so that it will output the required information
 * just by calling the function name.
 */

/**
 * If you want to go a step further, you can create your own custom WordPress loop for your component.
 * By doing this you could output a number of items within a loop, just as you would output a number
 * of blog posts within a standard WordPress loop.
 *
 * The example template class below would allow you do the following in the template file:
 *
 *    <?php if ( bp_example_has_items() ) : ?>
 *
 *    <?php while ( bp_example_items() ) : bp_example_the_item(); ?>
 *
 *       <p><?php bp_example_item_name() ?></p>
 *
 *    <?php endwhile; ?>
 *    
 * <?php else : ?>
 *
 *    <p class="error">No items!</p>
 *    
 * <?php endif; ?>
 *
 * Obviously, you'd want to be more specific than the word 'item'.
 *
 */

class BP_Zoneideas_Template {
   var $current_friendship = -1;
   var $item_count;
   var $items;
   var $item;
   
   var $in_the_loop;
   
   var $pag_page;
   var $pag_num;
   var $pag_links;
   
   function bp_zoneideas_template() {
      global $bp;
      
      $this->pag_page = isset( $_REQUEST['page'] ) ? intval( $_REQUEST['page'] ) : 1;
      $this->pag_num = isset( $_REQUEST['num'] ) ? intval( $_REQUEST['num'] ) : 10;

      // Friendship Requests
      $this->items = ''; // Example: bp_example_get_items( $bp->displayed_user->id );
      $this->total_item_count = ''; // Example: $this->items['total'];

      $this->item_count = count($this->items);
      
      $this->pag_links = paginate_links( array(
         'base' => add_query_arg( 'fpage', '%#%' ),
         'format' => '',
         'total' => ceil($this->total_item_count / $this->pag_num),
         'current' => $this->pag_page,
         'prev_text' => '&laquo;',
         'next_text' => '&raquo;',
         'mid_size' => 1
      ));
   }
   
   function has_items() {
      if ( $this->item_count )
         return true;
      
      return false;
   }
   
   function next_item() {
      $this->current_item++;
      $this->item = $this->items[$this->current_item];
      
      return $this->item;
   }
   
   function rewind_items() {
      $this->current_item = -1;
      if ( $this->item_count > 0 ) {
         $this->item = $this->items[0];
      }
   }
   
   function user_items() { 
      if ( $this->current_item + 1 < $this->item_count ) {
         return true;
      } elseif ( $this->current_item + 1 == $this->item_count ) {
         do_action('loop_end');
         // Do some cleaning up after the loop
         $this->rewind_items();
      }

      $this->in_the_loop = false;
      return false;
   }
   
   function the_item() {
      global $item, $bp;

      $this->in_the_loop = true;
      $this->item = $this->next_item();
            
      if ( 0 == $this->current_item ) // loop has just started
         do_action('loop_start');
   }
}

function bp_zoneideas_has_items() {
   global $bp, $items_template;

   $items_template = new BP_Zoneideas_Template( $bp->displayed_user->id );
   
   return $items_template->has_items();
}

function bp_zoneideas_the_item() {
   global $items_template;
   return $items_template->the_item();
}

function bp_zoneideas_items() {
   global $items_template;
   return $items_template->user_items();
}

function bp_zoneideas_item_name() {
   global $items_template;
   
   echo ''; // Example: $items_template->item->name;
}

function bp_zoneideas_item_pagination() {
   global $items_template;
   
   echo $items_template->pag_links;
}

?>