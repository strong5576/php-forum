<?php
//此檔為論壇的主要入口，檔案中使用到兩個特別的 mysql 語法 SELECT COUNT 與 SELECT MAX
  session_start();
  if(isset($_SESSION['auth_user']))
  {
    include_once("db_connect.php");
    include_once("header.php");
  
      echo '<table width="100%" border="0" align="center">';
      echo '<tr>
            <th width="40%">主題</th>
            <th width="10%">建立者</th>
            <th width="20%">建立日期</th>
            <th width="10%">回覆數</th>
            <th width="20%">最近的回覆</th>
            </tr>';
    
      $conn = db_connect();
      $sql_threads = "SELECT * FROM threads ORDER BY built_on";
    
      $result_threads = $conn->query($sql_threads);
    
      if($result_threads->num_rows > 0)
      {
        $num_rows = $result_threads->num_rows;
        for($i = 0; $i < $num_rows; $i++) //印出所有 thread
        {
          $thread_row = $result_threads->fetch_assoc();
        
          $thread_id = $thread_row['thread_id'];
        
          $sql_users = "SELECT * FROM users WHERE user_id =   ".$thread_row['created_by'];
          $result_user = $conn->query($sql_users);
          if(!$result_user)
            echo mysqli_error($conn);
          else
            $user_row = $result_user->fetch_assoc();
        
          //計算特定 thread 的資料筆數
          $sql_posts = "SELECT COUNT(*) FROM posts WHERE thread_id = ".$thread_row['thread_id'];  
          $post_num_result = $conn->query($sql_posts);
          $post_num = $post_num_result->fetch_row();
          $nums = (int)($post_num[0] - 1);
        
          //取出最大值的資料，既最後的回覆時間
          $sql_posts_last = "SELECT MAX(posted_on) FROM posts WHERE thread_id = ".$thread_row['thread_id'];
          $last_post_result = $conn->query($sql_posts_last);
          $last_post = $last_post_result->fetch_row();
          $last = $last_post[0];
        
          $built_on = date("Y/m/d H:i:s", $thread_row['built_on']);
          $last_reply = date("Y/m/d H:i:s", $last);
        
          echo '<tr>
                <td align="left">
                <a href="read.php?thread_id='.$thread_id.'" class="subject">'.$thread_row['subject'].
               '</a></td>
                <td align="center">'.$user_row['alias'].'</td>
                <td align="center">'.$built_on.'</td>
               <td align="center">'.$nums.'</td>
                <td align="center">'.$last_reply.'</td>
                </tr>';              
        }      
      }
      else
      {
        echo mysqli_error($conn);
      }
    
      echo '</table>';
    
    include("footer.php");
  }
  else
  {
    echo "你還未登入，無法進入論檀頁面<p>";
    echo "點選這裡回到主頁進行登入<br /><a href='index.php'>主頁</a></p>";
  }
?>