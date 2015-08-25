<?php

/**
 * This function should include all classes and functions that access the database.
 * In most BuddyPress components the database access classes are treated like a model,
 * where each table has a class that can be used to create an object populated with a row
 * from the corresponding database table.
 * 
 * By doing this you can easily save, update and delete records using the class, you're also
 * abstracting database access.
 */

class BP_Zoneideas_TableName {
   var $id;
   var $field_1;
   var $field_2;
   var $field_3;
   
   /**
    * bp_zoneideas_tablename()
    *
    * This is the constructor, it is auto run when the class is instantiated.
    * It will either create a new empty object if no ID is set, or fill the object
    * with a row from the table if an ID is provided.
    */
   function bp_zoneideas_tablename( $id = null ) {
      if ( $id ) {
         $this->id = $id;
         $this->populate( $this->id );
      }
   }
   
   /**
    * populate()
    *
    * This method will populate the object with a row from the database, based on the
    * ID passed to the constructor.
    */
   function populate() {
      global $wpdb, $bp, $creds;
      
      if ( $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$bp->zoneideas->table_name} WHERE id = %d", $this->id ) ) ) {
         $this->field_1 = $row->field_1;
         $this->field_2 = $row->field_2;
         $this->field_3 = $row->field_3;
      }
   }

   /**
    * save()
    *
    * This method will save an object to the database. It will dynamically switch between
    * INSERT and UPDATE depending on whether or not the object already exists in the database.
    */   
   function save() {
      global $wpdb, $bp;
      
      if ( $this->id ) {
         // Update
         $result = $wpdb->query( $wpdb->prepare( "UPDATE {$bp->zoneideas->table_name} SET field_1 = %d, field_2 = %d, field_3 = %d WHERE id = %d", $this->field_1, $this->field_2, $this->field_3, $this->id ) );
      } else {
         // Save
         $result = $wpdb->query( $wpdb->prepare( "INSERT INTO {$bp->zoneideas->table_name} ( field_1, field_2, field_3 ) VALUES ( %d, %d, %d )", $this->field_1, $this->field_2, $this->field_3 ) );
         $this->id = $wpdb->insert_id;
      }
      
      return $result;
   }

   /**
    * delete()
    *
    * This method will delete the corresponding row for an object from the database.
    */   
   function delete() {
      global $wpdb, $bp;
      
      return $wpdb->query( $wpdb->prepare( "DELETE FROM {$bp->zoneideas->table_name} WHERE id = %d", $this->id ) );
   }
   
   /* Static Functions */
   
   /**
    * Static functions can be used to bulk delete items in a table, or do something that
    * doesn't necessarily warrant the instantiation of the class.
    */
   
   function delete_all() {
      
   }
   
   function delete_by_user_id() {
      
   }
}
   


?>