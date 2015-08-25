<?php
/**
 * @desc Aux class to manage files
 * @package ZoneIdeas
 * @subpackage file
 * @author  Pedro Alves <alves@zoneideas.org> <eu@pedroalves.info>
 *
 */
class file
{

  /**
   * File to be processed
   *
   * @access private
   * @var string
   */
  private $sFile;

  /**
   * Class constructor
   *
   * @access public
   * @param string $sFile Source file
   */
  public function __construct($sFile='')
  {
    if ($sFile  != '')
    {
      $this->sFile   =  $sFile;
    }
  }

  /**
   * Read all content from a file and return as a string
   *
   * @access public
   * @return string
   */
  public function Read()
  {
    if ($this->sFile!='')
    {
      try
      {
        if ($this->Exists())
        {
          if ($this->IsReadable())
          return file_get_contents($this->sFile);
          else
          throw new FileException('can\'t read file "'.$this->sFile.'"');
        }
        else
        {
          throw new FileException('file "'.$this->sFile.'" does not exist');
        }
      }
      catch (Exception $e)
      {
        Debug::Log($e,ERROR);
        return false;
      }
    }
    return '';
  }

  /**
   * Write some content to a file
   *
   * @access public
   * @param string $sContent
   * @return boolean
   */
  public function Write($sContent)
  {
    try
    {
      return file_put_contents($this->sFile,$sContent);
    }
    catch (Exception $e)
    {
      Debug::Log($e,ERROR);
      return false;
    }
  }
   
  /**
   * Append some content to file
   *
   * @access public
   * @param string $sContent
   * @return boolean
   */
  public function Append($sContent)
  {
    try
    {
      return file_put_contents($this->sFile,$sContent,FILE_APPEND);
    }
    catch (Exception $e)
    {
      Debug::Log($e,ERROR);
      return false;
    }
  }

  /**
   * Check if the selected file is readable
   *
   * @access public
   * @return boolean
   */
  public function IsReadable()
  {
    return is_readable($this->sFile);
  }

  /**
   * Check if the selected file is writable
   *
   * @access public
   * @return boolean
   */
  public function IsWritable()
  {
    return is_writable($this->sFile);
  }

  /**
   * Check if the selected file is exists
   *
   * @access public
   * @return boolean
   */
  public function Exists()
  {
    return file_exists($this->sFile);
  }

  /**
   * Return the file name
   *
   * @access public
   * @return string
   */
  public function Name()
  {
    $sExt =  strrchr($this->sFile,'.');

    if ($sExt   != false) return substr($this->sFile,0,-strlen($sExt));

    return '';
  }

  /**
   * Return the file ext
   *
   * @access public
   * @return string
   */
  public function FileExt()
  {
    return strtolower(end(explode('.',$this->sFile)));
  }

  /**
   * Delete a file from server
   *
   * @access public
   * @return bool
   */
  public function Delete()
  {
    if ($this->Exists())   return unlink($this->sFile);

    return true;
  }
}
