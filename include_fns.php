<?php

function check_auth_user()  //檢查是否有登入
{
  if(isset($_SESSION['auth_user']))
  {
    return true;
  }
  else
  {
    return false;
  }
}

function display_login_form()
{
  ?>
  <form action="login.php" method="post">
    <input type="hidden" name="action" value="login" />
  <table border="0" align="center">
    <tr>
      <td>使用者名稱</td>
      <td><input type="text" name="username" size="50" value="" /></td>
    </tr>
    <tr>
      <td>密碼</td>
      <td><input type="password" name="password" size="50" value="" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" value="登入"></td>
    </tr>
  </table>
  </form>
  <?php
}


function display_subject_form()
{
?>
    <h2 align="center">新主題</h2>
    <form action="post.php" method="post">
      <input type="hidden" name="action" value="submit" />
    <table border="0" align="center">
      <tr>
        <td>主題名稱</td>
        <td><input type="text" name="subject" size="60" value="" /></td>
      </tr>
      <tr>
        <td>內容</td>
        <td><textarea name="message" cols="55" rows="10"></textarea></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" value="送出" /></td>
      </tr>
    </table>
    </form>
<?php
}

function display_reply_form()
{
?>
    <h2>留言</h2>
    <form action="read.php" method="post">
      <input type="hidden" name="action" value="reply" />
      <textarea name="reply" cols="60" rows="10" placeholder="Post a Reply"></textarea>
      <br />
      <input type="submit" value="送出留言" />
    </form>
<?php
}

// 以下三個函式為 user id, user name, user alias 的互相轉換，視顯示的需要而調用
function userid_to_alias($user_id)
{
  $conn = db_connect();
  $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
  $result = $conn->query($sql);
  if(!$result)
  {
    echo mysqli_error($conn);
    exit;
  }
  else
  {
    $row = $result->fetch_assoc();
    $alias = $row['alias'];
  }
  return $alias;
}


function username_to_userid($username)
{
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
  $conn->close();
  return $user_id;
}


function username_to_alias($username)
{
  require_once("db_connect.php");
  
  $conn = db_connect();
  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = $conn->query($sql);
  
  if($result->num_rows > 0)
  {
    $row = $result->fetch_assoc();
    $alias = $row['alias'];
    return $alias;
  }
  else
  { 
    echo mysqli_error($conn);
    return false;
  }
} 
 
?>