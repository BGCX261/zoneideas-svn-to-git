<?php
/**
 * @package    zoneideas
 * @subpackage user
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

if (basename($_SERVER["SCRIPT_NAME"])==basename(__FILE__))die();

/**
 *
 * @package zoneideas
 * 
 * @final
 */
final class User
{
  public $user_id;
  public $user_name;
  public $user_password;
  public $user_email;
  public $user_regdate;

  public static $current;

  /**
   * 
   * @static
   * @return User|false     
   */
  public static function GetById($user_id)
  {
    
    if (empty($user_id)) return new User();
    
    $cmd=sprintf("SELECT * FROM zi_users WHERE user_id=%d",$user_id);
    
    try
    {
      $data = Database::Query($cmd);
      if (empty($data))
       throw new UserException("can't get user");

      $obj = new User();

      foreach ($data[0] as $key=>$value)
      {
        $obj->$key=($value);
      }
    }
    catch (Exception $e)
    {
      Debug::Log($e,WARNING);
      return false;
    }

    return $obj;
  }

  /**
   * 
   * @static
   * @return User     
   */
  public static function Create($user_name,$user_email,$user_password)
  {
    $obj = new User();

    $obj->user_name     = Database::SafeData($user_name);
    $obj->user_email    = Database::SafeData($user_email);
    $obj->user_password = md5($user_password);
    $obj->user_regdate  = time();

    return $obj; 
  }


  /**
   * 
   * @static
   * @return User|false     
   */
  public static function Add($obj)
  {
    $cmd = sprintf("INSERT INTO zi_users (user_name,user_email,user_password,user_regdate) VALUES('%s','%s','%s',%d)",
           $obj->user_name,$obj->user_email,$obj->user_password,$obj->user_regdate);
        
    try
    {
      if (!Database::Query($cmd,false)) throw new UserException("can't add user");
      
      $obj->user_id=Database::GetLastInsertId();
    }
    catch (Exception $e)
    {
      Debug::Log($e,ERROR);
      return false;
    }
    return $obj;
  }
  
  /**
   * Update user account
   * For now used only for new password
   *
   * @param object $user
   *
   * @return boolean if updated
   */                      
  public static function Update($user)
  {
    if (!User::GetById($user->user_id))
    {
      Debug::Log($e,ERROR);
      return false;
    }
    
    $cmd  = sprintf("UPDATE zi_users SET user_password=md5('%s'),user_name='%s',user_email='%s' WHERE user_id=%d",
                    $user->user_password,$user->user_name,$user->user_email,$user->user_id);
    try
    {  
      if (!Database::Query($cmd,false)) throw new UserException("can't update user");
    }
    catch (Exception $e)
    {
      Debug::Log($e,ERROR);
      return false;
    }
    return true;
    
  }


  /**
   * 
   * @static
   * @return User     
   */
  public static function CheckUser($user_name,$user_password)
  {
    $user_password = md5($user_password);

    $obj  = new User();
    $cmd  = sprintf("SELECT * FROM zi_users WHERE user_name='%s' AND user_password='%s'",Database::SafeData($user_name),$user_password);
    $data = Database::Query($cmd);

    if (!empty($data))
       $obj = User::GetById($data[0]["user_id"]);
    else
       $obj = User::GetById(0);

    return $obj;
  }


  /**
   * 
   * @static
   * @return boolean     
   */
  public static function Logged()
  {
    if (empty(self::$current->user_id))
       return false;
    else
       return true;
  }


  /**
   * 
   * @static
   * @return boolean     
   */
  public static function FindUser($user_name)
  {
    $obj = new User();
    $cmd = sprintf("SELECT * FROM zi_users WHERE user_name='%s'",Database::SafeData($user_name));

    $data = Database::Query($cmd);
    
    if (empty($data))
       return false;
    else
       return true;
  }
  
  /**
   * Checks if $user_email is in database >> user is registered
   *
   * @param string $user_email 
   *
   * @return User|false      
   */            
  public static function FindUserByEmail($user_email)
  {
    $obj = new User();
    $cmd = sprintf("SELECT * FROM zi_users WHERE user_email='%s'",Database::SafeData($user_email));

    $data = Database::Query($cmd);
    
    if (empty($data))  return false;
        
    $obj = new User();

    foreach ($data[0] as $key=>$value) //array to object
    {
      $obj->$key=($value);
    }
    return $obj;
  }
  
  
  /**
   * Generates password from numbers and small characters, default length is 8
   * 
   * @param integer $length  how long should the password be, default is 8
   *                
   * @return string  generated password
   */                  
  public static function GeneratePassword($length = 8)
  {
    $chars = "234567890abcdefghijkmnopqrstuvwxyz";
    $i = 0;
    $password = "";
    while ($i <= $length) 
    {
      $password .= $chars{mt_rand(0,strlen($chars))};
      $i++;
    }
    return $password;
  }


  /**
   * 
   * @static
   * @return void
   */
  public static function Logout()
  {
    Session::StartUser(User::GetById(0));
  }


  public function IsAdmin()
  {
    if (strtolower(Settings::$admin_user)==strtolower($this->user_name)) 
       return true; 
    else  
       return false; 

  }


}
