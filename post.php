<?php
  include_once("header.php");
  include_once("include_fns.php");
  include_once("db_connect.php");

  if(isset($_POST['action']) and $_POST['action'] == 'submit')
  {
    processForm();
  }
  else
  {
    displayForm($error="");
  }

  function displayForm($errorMessage)
  {
    echo "<p>$errorMessage</p>";
    display_subject_form(); // 建立新主題 
  }
  
  function processForm()
  {
    $errorMessage = "";
    
    if($_POST['subject'] == "" or $_POST['message'] == "")
    {
      $errorMessage = "<p>請完整填寫各欄位</p>";
      displayForm($errorMessage);
      exit; //這條指令有沒有必要？？？
    }
    
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $time = time();
    
    // 底下這段落可以改調用 username_to_userid() function 取代
    $conn = db_connect();
    $sql = "SELECT * FROM users WHERE username = '{$_SESSION['auth_user']}'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
      $row = $result->fetch_assoc();
      $user_id = $row['user_id'];
    }
    else
    {
      echo mysqli_error($conn);
      exit;
    }
      
    // 建立新主題的同時也需輸入一則留言，所有底下會有 threads, posts 兩段資料表的操作 (INSERT INTO)
    
    $sql = "INSERT INTO threads (created_by, subject, built_on) VALUES ('$user_id', '$subject', '$time')";
    $result = $conn->query($sql);
    if($result)
      $thread_id = mysqli_insert_id($conn);
    else
    {
      echo mysqli_error($conn);
      exit;  
    }
      
    $sql = "INSERT INTO posts (thread_id, poster, message, posted_on) 
            VALUES ('$thread_id', '$user_id', '$message', '$time')";
    $result = $conn->query($sql);
    if(!$result)
      echo "There are problems about writing data to database.";
    else
      echo "新主題建立成功，可以開始留言了！<a href='forum.php'>論壇</a>";    
  }
  
  include("footer.php");
?>