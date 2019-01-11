<?php
// 此檔是本專案最重要也最複雜的，主要用於顯示所有留言與回覆，也可以進行留言與回覆，版面設計時有參考 
// facebook 的排版方式
 
  include_once("header.php");
  include_once("db_connect.php");
  include_once("include_fns.php");
  
  if(isset($_REQUEST['thread_id']))
    $thread_id = $_REQUEST['thread_id'];
    
  if(isset($_REQUEST['post_id']))
    $post_id = $_REQUEST['post_id'];
  
  // 記錄展開回覆與否  
  if(!isset($_SESSION['expanded']))
    $_SESSION['expanded'] = array();
  
  // 展開回覆  
  if(isset($_GET['expand']))
    $_SESSION['expanded'][$_GET['expand']] = true;
  
  if(isset($_POST['action']) && $_POST['action'] == 'poke')
  {
    processPoke(); //處理留言資料
  }
  elseif(isset($_POST['action']) && $_POST['action'] == 'reply')
  {
    processReply(); //處理回覆資料
  }  
  else
  {
    display($thread_id);  //顯示留言版
  }
  
  function display($thread_id)
  {    
    $conn = db_connect();
    $sql_thread = "SELECT * FROM threads WHERE thread_id = '$thread_id'";
    $result_thread = $conn->query($sql_thread);
    if(!$result_thread)
      echo mysqli_error($conn);
    else
    {
      $row_thread = $result_thread->fetch_assoc();
      $subject = $row_thread['subject'];   //讀取資料庫內的特定主題名稱 
    }
    
    echo "<h2 id='write'>$subject</h2>";
    echo "<hr>";
?>
    <!-- 顯示留言輸入框 -->
    <!-- form 內若只有一欄 input 且type為text 則按enter 既可submit  -->
    <form action="read.php" method="post">
      <input type="hidden" name="action" value="poke" />
      <input type="hidden" name="thread_id" value="<?php echo $thread_id ?>">
      <input type="input" name="poke" class="poke" size="60" value="" placeholder="留言....." />
      <br />按enter鍵發表
    </form>
<?php
    
    $sql_post = "SELECT * FROM posts WHERE thread_id = '$thread_id' ORDER BY posted_on DESC";
    $result_post = $conn->query($sql_post);    
    if($result_post->num_rows > 0)
    {
      while($row_post = $result_post->fetch_assoc()) 
      {
        if(!$row_post['parent'])  //讀取每一筆 parent 為 0 的資料(留言而不是回覆)
        {        
          $sql_user = "SELECT * FROM users WHERE user_id = ".$row_post['poster'];
          $result_user = $conn->query($sql_user);
          if(!$result_user)
            echo mysqli_error($conn);
          else
          { // poster(user_id) 轉 User alias
            $row_user = $result_user->fetch_assoc();
            //$userName = $row_user['username'];
            $userAlias = $row_user['alias']; //user id 轉為 user alias
          }
        
          $posted_on = date("Y/m/d H:i:s", $row_post['posted_on']); //timestamp 轉為 datetime
          $post_id = $row_post['post_id'];
             //這裡 <p>設為錨點，按下<a>回覆</a>後畫面來到這裡
          echo "<p id='$post_id'><b><font color='blue'>$userAlias</b></font>($posted_on)
                <br />&nbsp;&nbsp;{$row_post['message']}<br />"; //列印出留言者，留言時間，留言內容
          echo '<a href="read.php?thread_id='.$thread_id.'&post_id='.$post_id.'#'.$post_id.'" class="reply">
                <b>&nbsp;&nbsp;回覆</b></a>
                <a href="#write" class="reply">&nbsp;&nbsp;留言...</a>'; //畫面跳到 write 錨點
                //#write錨點 為最上面的留言框
          if(isset($_GET['post_id']))
          {
            if($post_id == $_GET['post_id'])  //在這條留言按下<回覆>後顯示回覆輸入框
            {
?>            
              
              <form action="read.php" method="post">
               <input type="hidden" name="action" value="reply" />
               <input type="hidden" name="post_id" value="<?php echo $post_id ?>" />
               &nbsp;&nbsp;&nbsp;<input type="hidden" name="thread_id" value="<?php echo $thread_id ?>" />
               <input type="text" name="reply" class="reply" value="" size="60" placeholder="回覆..." />
              </form>
<?php
            }
          }
          $children = $row_post['children'];
          if($children) //若這則留言有被回覆 children == 1
          {
            $sql = "SELECT * FROM posts WHERE parent = '$post_id'";
            $result_child = $conn->query($sql);
          
            if($result_child->num_rows > 0)
            {
              $row_num = $result_child->num_rows;
              if(isset($_SESSION['expanded'][$post_id])) //若這條留言在 $_SESSION['expanded'] 內設定為 true
              {                                          //則顯示所有回覆
                while($row_child = $result_child->fetch_assoc())
                {
                  $alias = userid_to_alias($row_child['poster']);
                  $posted = date("Y/m/d H:i:s", $row_child['posted_on']);
                  $message = $row_child['message'];
              
                  echo "<br /><b><font color='blue'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$alias</b></font>($posted)
                        <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$message";  
                }  
              }
              else //若這條留言在 $_SESSION['expanded'] 沒有設定則顯示 <n則回覆> 超連結，按下後就顯示所有回覆
              {                                                                    //設定錨點為 $post_id
                echo "<a class='reply' href='read.php?expand=$post_id&thread_id=$thread_id#$post_id'>
                      <br /><font color='red'>&nbsp;&nbsp;&#8618; $row_num 則回覆</font></a>";   
              }                                                                           
              unset($_SESSION['expanded'][$post_id]); //刪除這條留言在 $_SESSION['expanded'] 的設定            
            }                                         //這樣，當下次進入時回覆內容的顯示是關閉的
          }
        }
      }
     // $conn->close();
    }
    else
    {
      echo mysqli_error($conn);
    }
    
    include("footer.php");    
  }
  
  function processPoke()
  { 
    if(isset($_POST['thread_id']))
      $thread_id = $_POST['thread_id'];
    
    if(isset($_POST['poke']))
    {
      $poke = $_POST['poke'];
    }
    
    if($poke == "") //輸入框內無內容，此時若按 enter 則不做任何動作
    {
      display($thread_id);
      exit;
    }
    else
    {
      $conn = db_connect();
      // username 轉 user_id(poster)
      // 可以調用 username_to_userid($username) 函式就可取得 user id 如此就可省略這部分操作
      $sql_poster = "SELECT * FROM users WHERE username = '{$_SESSION['auth_user']}'";
      $result_user = $conn->query($sql_poster);
      if(!($result_user->num_rows > 0))
        echo mysqli_error($conn);
      else
      {
        $row_user = $result_user->fetch_assoc();
        $user_id = $row_user['user_id'];
      }
    
      $time = time();
    
      $sql = "INSERT INTO posts (thread_id, poster, message, posted_on, children, parent) 
              VALUES ('$thread_id', '$user_id', '$poke', '$time', 0, 0)";
            
      $result = $conn->query($sql);
      if(!$result) 
      {
        echo mysqli_error($conn);
        exit;
      }
      
      display($thread_id); 
    }
         
  }
  
  
  function processReply()
  {
    if(isset($_POST['thread_id']))
      $thread_id = $_POST['thread_id'];
      
    if(isset($_POST['post_id']))
      $post_id = $_POST['post_id'];
      
    if(isset($_POST['reply']))
      $reply = $_POST['reply'];
      
    if($reply == "") // 誤寫成 if($reply = "") 太離譜了！
    {
      display($thread_id);
      exit;
    }
    
    $posted_on = time();
    $parent = $post_id;
    $poster = username_to_userid($_SESSION['auth_user']);
    
    $conn = db_connect();
    $sql_insert = "INSERT INTO posts (thread_id, poster, message, posted_on, children, parent)
            VALUES ('$thread_id', '$poster', '$reply', '$posted_on', 0, '$parent')";
    //加入一則資料到 posts 注意 parent 欄位要設定為被回覆的那則資料的 post_id        
    $result_insert = $conn->query($sql_insert);
    if(!$result_insert)
    {
      echo mysqli_error($conn);
      exit;
    }
    
    $sql_update = "UPDATE posts SET children = 1 WHERE post_id = '$post_id'";
    //身為 parent 的那則資料，children 欄位設為 1 (代表有 children)
    $result_update = $conn->query($sql_update);
    if(!$result_update)
    {
      echo mysqli_error($conn);
      exit;
    }
    display($thread_id);
    //header("Location: read.php?thread_id=$thread_id");    
  }
?>