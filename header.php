<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <style>
    .title {  
			font-size: 30px; font-weight: bold; color: #ffffff;
      font-family: "標楷體", "Microsoft YaHei", "Times New Roman"; 
			margin-top: 5px; margin-bottom: 5px; margin-left: 10px; 
			padding-top: 5px; padding-bottom: 5px; padding-left: 20px;
      background-color: #003366;  
      text-align: center; 
		} 
     .content {
			background-color: #f5f5f5; 
			padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; 
			margin-top: 10px; margin-right: 10px; margin-bottom: 10px; margin-left: 10px;
		}
    a.navlink { font-size: 18px;}
    a.navlink:link { color: #003366; text-decoration: none;}
    a.navlink:visited { color: #003366; text-decoration: none;}
    a.navlink:hover { color: #ffffff; background-color: #003366; text-decoration: none;}
    .welcome {
      font-size: 14px; font-weight: bold; color: black;
      background-color : pink;       
    }
    .error {
      font-size: 16px; font-weight: bold;
      color: red;
    }
    body { 
      font-size: 15px;
      font-family: "標楷體", "Microsoft YaHei", "Times New Roman";
    }
    .submit { 
      background-color: #55535e;  
      font-family: "標楷體", "Microsoft YaHei", "Times New Roman";
      font-size: 20px; font-weight: bold; color: #ffffff;
    }
    a.subject { color:#000000; text-decoration: none; }
    a.index { color: #ffffff; text-decoration: none; }
    a.reply { color: #000000; text-decoration: none; }
    input.poke {
      width: 60%;
      padding: 10px 5px;
      margin: 0px 0;
      border: 1px solid #ccc;
      border-radius: 30px ;
    }
    input.reply {
      width: 60%;
      padding: 5px 5px;
      margin: 0px 0px;
      border: 1px solid #ccc;
      border-radius: 30px;
    } 
    </style>    
  </head>
  <body>   <!--用 table 做排版是目前最普遍的方法 -->
    <table width="95%" border="0" cellspacing="10" cellpadding="0" align="center">
      <tr>
        <td colspan="2"><p class="title"><a href="index.php" class="index">江山如此多嬌之天涯論壇</a></p></td>
      </tr>
      <tr>
        <td valign="top" width="10%" nowrap="nowrap"><b>
<?php
  echo '<a href="index.php" class="navlink"> 主 頁 </a><br />';
  echo '<a href="forum.php" class="navlink"> 論 壇 </a><br />';
  
  if(isset($_SESSION['auth_user'])) //登入後顯示
  {                                          // $_SERVER['PHP_SELF'] 為 /test/case10_1/forum.php
    if(stripos($_SERVER['PHP_SELF'], 'forum.php')) //此方法很獨特，記下來！
    {  
      echo '<a href="post.php" class="navlink"> 新主題 </a><br />'; // 此連結只在 forum.php 頁面顯示
    }
    
    echo '<a href="logout.php" class="navlink"> 登 出 </a><br />';
    
    include_once("include_fns.php");
    $alias = username_to_alias($_SESSION['auth_user']);
    echo '<p class="welcome"><marquee scrollamount="2">歡迎 '.$alias.'加入討論</marquee></p>';
  }
  else   // 未登入時顯示
  {
    echo '<a href="register.php" class="navlink"> 註 冊 </a><br />';
    echo '<a href="login.php" class="navlink"> 登 入 </a>';
  }

  echo '<p><a href="search.php" class="navlink">搜尋主題</a></p>';
?>
        </b></td>
        <td valign="top" class="content">

    
    
    
    
    
    
    
    