<?php
// 此檔為登入用，將 form 顯示與 submit 後的數據接收處理寫在同一個檔案，
// 在這整個論壇專案中有用到 form 的部分都是用這個方式處理
include_once("db_connect.php");
session_start();

if(isset($_POST['action']) and $_POST['action'] == 'login')
{
  processLogin();
}
else
{
  displayLogin($error="");
}


function displayLogin($errorMessage)
{
  if($errorMessage)
    echo '<p align="center">'.$errorMessage.'</p>';
  else
    echo '<h1 align="center">請登入</h1>'; 
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <style>
      body {
        background-color: white;
        font-size: 18px;
        font-family: "標楷體", "Microsoft YaHei", "Times New Roman";
      }
      .submit {
        background-color: blue;
        font-size: 20px; font-weight: bold; color: #ffffff;
        font-family: "標楷體", "Microsoft YaHei", "Times New Roman";
      }
      .error {
        font-size: 21px; font-weight: bold;
        color: red;
        text-align: center;
      }
    </style>    
  </head>
  <body>
    <form action="login.php" method="post">
      <input type="hidden" name="action" value="login" />
    <table border="0" align="center">
      <tr>
        <td>使用者名稱</td>
        <td><input type="text" name="username" size="50" value="" placeholder="username" /></td>
      </tr>
      <tr>
       <td>密碼</td>
        <td><input type="password" name="password" size="50" value="" placeholder="password" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" class="submit" value="登入" /></td>
      </tr>
    </table>
    </form>
  </body>
</html>
<?php 
}


function processLogin()
{
  $errorMessage = "";
  
  if($_POST['username'] == "" || $_POST['password'] == "")
  {
    $errorMessage = '<p class="error">請完整輸入使用者名稱及密碼</p>';
    displayLogin($errorMessage);
  }
  else
  {  
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $conn = db_connect();
    $sql = "SELECT * FROM users WHERE username = '$username' and password = sha1('$password')";
    $result = $conn->query($sql);
  
    if($result->num_rows > 0)
    {
      //$row = $result->fetch_assoc();      
      $_SESSION['auth_user'] = $username;
      header("Location: index.php");  
    }
    else
    {
      $errorMessage = '<p class="error">您輸入的使用者名稱或密碼錯誤，請重新輸入</p>';
      displayLogin($errorMessage);
    }
  }
}
?>