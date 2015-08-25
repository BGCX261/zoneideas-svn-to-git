<?php
/**
 * @package    zoneideas
 * @subpackage idea
 * @author     Serg Podtynnyi <serg.podtynnyi@gmail.com>
 */

/**
 *
 *
 */
ob_start();

include_once("../core.php");

$action = false;


if (!RESTRICT_ALL || User::Logged())
{

  $id = (int)$_SERVER["QUERY_STRING"];

  // If remove idea 
  if(isset($_GET["removeidea"]))
  {
    $idea = Idea::GetById($id);

    if ( Idea::Remove($idea,User::$current) )
    {
      header("Location:".PREFIX."/dashboard/");
      exit();
    }
    else
    {
      $error_message = I18n::L("This idea can not be removed by you.");
      Viewer::AddData("error_message",$error_message);
    }
  }

  // if remove comment
  if(isset($_GET["removecomment"]))
  {
    $idea = Idea::GetById($id);
    $comment = Comment::GetById($_GET["removecomment"]);

    if ( Comment::Remove($comment,User::$current) )
    {
      header("Location:".PREFIX."/idea?{$idea->idea_id}");
      exit();
    }
    else
    {
      $error_message = I18n::L("This comment can not be removed by you.");
      Viewer::AddData("error_message",$error_message);
    }
  }

  // If Rated Up or Down

  if ( isset($_POST["rate_plus"]) || isset($_POST["rate_minus"]) )
  {
    $idea = Idea::GetById($id);
    
    if (empty($_POST["comment_text"])) $error_message = I18n::L("Please fill comment text.");
     
    if (empty($error_message))
    {
      if (!Rate::Find($idea,User::$current))
      {
        if (isset($_POST["rate_plus"]))  Idea::RatePlus($idea);
        if (isset($_POST["rate_minus"])) Idea::RateMinus($idea);

        $comment = Comment::Add(Comment::Create($_POST["comment_text"],$idea,User::$current));
        $comment_lastnumber = sizeof(Comments::GetByIdea($idea));

        Notify::NotifyOfIdeaRate(User::GetById($idea->user_id),User::$current,$idea,$comment,isset($_POST["rate_plus"]));

        header("Location:".PREFIX."/idea?".$idea->idea_id."#comment_{$comment_lastnumber}");
        exit();
      }
      else
      {
        $error_message ="You already rated this idea.";
        Viewer::AddData("error_message",$error_message);
      }
    }
    else
    {
      Viewer::AddData("error_message",$error_message);
    }
    $action = "rate";
  }


  // If Commented only

  if ( isset($_POST["comment_only"]) )
  {
    $idea = Idea::GetById($id);
    
    if (empty($_POST["comment_text"])) $error_message = I18n::L("Please fill comment text.");
     
    if (empty($error_message))
    {
      $comment = Comment::Add(Comment::Create($_POST["comment_text"],$idea,User::$current));
      $comment_lastnumber = sizeof(Comments::GetByIdea($idea));

      Notify::NotifyOfIdeaComment(User::GetById($idea->user_id),User::$current,$idea,$comment);

      header("Location:".PREFIX."/idea?".$idea->idea_id."#comment_{$comment_lastnumber}");
      exit();
    }
    else
    {
      Viewer::AddData("error_message",$error_message);
    }
    $action = "comment";
  }


  // New idea view

  if(isset($_GET["new"]))
  {
    if(User::Logged())
    {
      Viewer::UseTemplate("new_idea.tpl");
      Viewer::AddData("title", I18n::L("Title New Idea"));
      $action = "new_idea";
    }
    else
    {
      Viewer::Restricted();
      $action = "restricted";
    }
  }


  // If Posted new idea

  if (isset($_POST["newidea"]))
  {
    if (User::Logged())
    {
      
      // Validation for user input 

      if ( (empty($_POST["idea_title"])) || (empty($_POST["idea_description"])) ) $error_message = I18n::L("Please fill title and description.");
    
      if (strlen($_POST["idea_title"])>115 ) $error_message = I18n::L("Your idea title is too long.");
      
      if (empty($error_message))
      {
        $idea = Idea::Add(Idea::Create($_POST["idea_title"],$_POST["idea_description"],User::$current));
     
        header("Location:".PREFIX."/idea?".$idea->idea_id);
        exit();
      }
      else
      {
        Viewer::AddData("idea_title",$_POST["idea_title"]);
        Viewer::UseTemplate("new_idea.tpl");
        Viewer::AddData("title", I18n::L("Title New Idea"));
        Viewer::AddData("error_message",$error_message);
      }
    }
    else
    {
      Viewer::Restricted();
    }
    $action = "new_idea";
  }


  // Default view

  if(!empty($id))
  {
    if ($idea = Idea::GetById($id))
    {
      Viewer::AddData("comments",Comments::GetByIdea($idea));
      Viewer::AddData("idea",$idea);
      Viewer::AddData("title",$idea->idea_title);
    
      if (isset($_GET["rate_plus"]))$rated=3;
      elseif (isset($_GET["rate_minus"]))$rated=2;
      else $rated=1;

      if (User::Logged())
      {
        $rate=Rate::Find($idea,User::$current);
      
        if (!empty($rate)) $rated=4;

        Viewer::AddData("rated",$rated);
      }

      Viewer::UseTemplate("idea.tpl");
      $action = "idea";
    }   
  }
} /* end if RESTRICT_ALL && User::Logged() */
else
{
  Viewer::Restricted();
  $action = "idea";
}


if (!$action) Viewer::RequestError();

Viewer::AddData("action",$action);
Viewer::Show();
ob_end_flush();
