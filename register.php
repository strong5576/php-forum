<?php
//此檔為註冊用，將 form 顯示與 submit 後的數據接收處理寫在同一個檔案
if(isset($_POST['action']) and $_POST['action'] == 'register')
{
  processForm();
}
else
{
  displayForm(array(), array());
} 
?>


<?php  
function displayForm($post, $errorMessages)
{
  if($errorMessages)
  {
    foreach ($errorMessages as $errorMessage)
    {
      echo "<p>$errorMessage</p>";
    }  
  }
  else
  {
    echo '<h2 align="center">歡迎加入江山如此多嬌之天涯論壇，請填寫以下表格以完成註冊。</h2>';
  }
?>
  <!DOCTYPE html>
  <html>
    <head>
      <title></title>
      <style>
        body { 
          background-color: #eee8aa; font-size: 18px;
          font-family: "標楷體", "Microsoft YaHei", "Times New Roman";
        }
        .submit { 
          background-color: #55535e;  
          font-family: "標楷體", "Microsoft YaHei", "Times New Roman";
          font-size: 20px; font-weight: bold; color: #ffffff;
        }
      </style>    
    </head>
    <body> 
      <h2 align="center">會員註冊</h2>
      <div align="center">
      <table border="0">
      <form action="register.php" method="post">
        <input type="hidden" name="action" value="register" />
        <tr>
          <td>會員名稱</td>
          <td><input type="text" name="username" size="60" placeholder="username"
              value="<?php if(isset($post['username'])) echo $post['username'] ?>"  /></td>
        </tr>                                                                           
        <tr>
          <td>密碼</td>
          <td><input type="password" name="password1" size="40" value="" placeholder="password" /></td>
        </tr>
        <tr>
          <td>確認密碼</td>
          <td><input type="password" name="password2" size="40" value=""  placeholder="confirm password" /></td>
        </tr>
        <tr>
          <td>暱稱（別名）</td>
          <td><input type="text" name="alias" size="60" placeholder="alias" 
              value="<?php if(isset($_POST['alias'])) echo $_POST['alias'] ?>" /></td>
        </tr>
        <tr>
          <td>電子郵件</td>
          <td><input type="text" name="email" size="60" placeholder="email address"
              value="<?php if(isset($post['email'])) echo $post['email'] ?>"  /></td>
        </tr>
        <tr>
          <td colspan="2" align="center" ><input type="submit" class="submit" value="註冊" />
          </td>
        </tr>
      </form>
      </table>
      </div>
    </body>
  </html>
<?php
}
  
function processForm()
{
  if(isset($_POST['username']))
    $username = $_POST['username'];
  if(isset($_POST['password1']))
    $password1 = $_POST['password1'];
  if(isset($_POST['password2']))
    $password2 = $_POST['password2'];
  if(isset($_POST['alias']))
    $alias = $_POST['alias'];
  if(isset($_POST['email']))
    $email = $_POST['email'];
    
  $time = time();
    
  $errorMessages = array();
    
  if($username && $password1 && $password2 && $alias && $email)
  {
    if($password1 == $password2)
    {
      include("db_connect.php");
      $conn = db_connect();
      $sql = "INSERT INTO users (username, password, alias, email, join_date) 
              VALUES ('$username', sha1('$password1'), '$alias', '$email', '$time')";
      $result = $conn->query($sql);
      if(!$result)
        //$errorMessages[] = mysqli_error($conn);
        $errorMessages[] = "資料庫存取出現錯誤，請再試一次！";
        
    }
    else
    {
      $errorMessages[] = '<p style="color: black; background-color: red; text-align:center">
        請確認密碼一致</p>';  
    }
  }
  else
  {
    $errorMessages[] = '<p style="color: black; background-color: red; text-align: center">
      表單填寫不完整，請完整填寫各欄位</p>';  
  }
  
  if($errorMessages)
  {
    displayForm($_POST, $errorMessages);
  }
  else
  {
    displayThanks();
  }  
}

function displayThanks()
{
  echo '<p style="font-family:標楷體; font-size: 25px" >註冊成功，登入後您可以參與論壇內各主題的討論</p>';
  echo '<a href="index.php">首頁</a>';
}
?>


  