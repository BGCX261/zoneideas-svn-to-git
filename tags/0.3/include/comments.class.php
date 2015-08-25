<?php
/**
 * @package    zoneideas
 * @subpackage comments
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 * 
 * 
 */
class Comments 
{

  private $collection;

  /**
   *  @access public
   *  @static
   *  @param $idea Idea
   *  @param $limit integer
   *  @return Comments|false
   */  
  public static function GetByIdea($idea,$limit=50)
  {
    $cmd = sprintf("SELECT comment_id FROM zi_comments WHERE idea_id=%d ORDER BY comment_date DESC LIMIT %d",$idea->idea_id,$limit);

    return self::GetCollectionData($cmd,"can't get comments for idea");  
  }

  
  /**
   *  @access public
   *  @static
   *  @param $idea User
   *  @param $limit integer
   *  @return Comments|false
   */  
  public static function GetByUser($user,$limit=50)
  {
    $cmd = sprintf("SELECT comment_id FROM zi_comments WHERE user_id=%d ORDER BY comment_date DESC LIMIT %d",$user->user_id, $limit);
   
    return self::GetCollectionData($cmd,"can't get comments for user");
  }


  /**
   *  function to not repeating same code in every method
   *  $query   sql query
   *  $message  message throwed by exception
   *  @access private
   *  @static
   *  @param $query string
   *  @return Comments|false
   */  
  private static function GetCollectionData($query,$message="error while getting comments")
  {

    if (empty($query)) return false;
    
    $obj = new Comments();

    try
     {
       $data = Database::Query($query);

       if (empty($data)) throw new CommentsException($message);
     
       foreach ($data as $row)
       {
         $obj->collection[] = Comment::GetById($row["comment_id"]);
       }
     }
     catch (Exception $e)
     {
       Debug::Log($e,WARNING);
       return false;
     }
     return $obj->collection;
  }


  /**
   *
   * @access public
   * @static
   * @param $idea Idea
   * @return integer|false
   */
  public static function GetCountByIdea($idea)
  {
    $cmd = sprintf("SELECT count(comment_id) AS comments_count FROM zi_comments WHERE idea_id=%d",$idea->idea_id);

    try
    {
      $data = Database::Query($cmd);

      if (empty($data)) throw new IdeaException("can't get comments count for idea");
    }

    catch (Exception $e)
    {
      Debug::Log($e,ERROR);
      return false;
    }
    return $data[0]["comments_count"];
  }
}
