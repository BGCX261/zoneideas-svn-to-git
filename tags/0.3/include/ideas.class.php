<?php
/**
 * @package    zoneideas
 * @subpackage ideas
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 * 
 * 
 */
class Ideas 
{

  private $collection;

  public static function GetByRate($rate=0,$limit=100)
  {
    $cmd=sprintf("SELECT idea_id FROM zi_ideas WHERE idea_rate>=%d ORDER BY idea_rate DESC LIMIT %d",$rate,$limit);

    return self::GetCollectionData($cmd,"can't get ideas for top rated");  
  }

  public static function GetByActivity($limit=100)
  {
    $cmd=sprintf("SELECT idea_id,count(comment_id) as comments_count FROM zi_comments WHERE idea_id IN (SELECT idea_id FROM zi_ideas) GROUP BY idea_id ORDER BY comments_count DESC LIMIT %d",$limit);

    return self::GetCollectionData($cmd,"can't get ideas for top rated");  
  }
 
  public static function GetByLastTime($limit=100)
  {
    $cmd=sprintf("SELECT idea_id FROM zi_ideas ORDER BY idea_date DESC LIMIT %d",$limit);

    return self::GetCollectionData($cmd,"can't get ideas for last time");  
  }

  public static function GetByUser($user,$limit=100)
  {
    $cmd=sprintf("SELECT idea_id FROM zi_ideas WHERE user_id=%d ORDER BY idea_date DESC LIMIT %d", $user->user_id, $limit);
   
    return self::GetCollectionData($cmd,"can't get ideas for user");
  }

  public static function SearchByTitle($q,$limit=100)
  {
    $cmd=sprintf("SELECT idea_id FROM zi_ideas WHERE idea_title LIKE \"%%%s%%\" ORDER BY idea_date DESC LIMIT %d", Database::SafeData($q), $limit);

    return self::GetCollectionData($cmd,"can't get ideas for this search");
  }

  /**
   *  function to not repeating same code in every method
   *  $query   sql query
   *  $message  message throwed by exception
   *  @access private
   *  @static
   *  @return Ideas|false
   */  
  private static function GetCollectionData($query,$message="error while getting ideas")
  {
  
    if (empty($query)) return false;

    $obj = new Ideas();
    try
    {
      $data = Database::Query($query);

      if (empty($data)) throw new IdeasException($message);
    
      foreach ($data as $row)
      {
        $obj->collection[] = Idea::GetById($row["idea_id"]);
      }
    }

    catch (Exception $e)
    {
      Debug::Log($e,WARNING);
      return false;
    }
    return $obj->collection;
  }

}
