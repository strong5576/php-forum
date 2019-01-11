<?php
//此檔為搜尋主題用， 有用到 mysql 的 LIKE %keyword% 語法， 將搜尋到的結果用 <ul> 列表顯示並做超聯結到各主題
//搜尋的關鍵字用 str_ireplace() function 操作做高亮顯示
  include_once("header.php");
  include_once("db_connect.php");

  if(isset($_POST['action']) && $_POST['action'] == 'search')
  {
    processSearch();
  }
  else
  {
    displaySearch("", "");
  }
  
  function displaySearch($errorMessage="")
  {
    echo $errorMessage;
    ?>
    <form action="search.php" method="post">
      <input type="hidden" name="action" value="search" />
      搜尋主題<br />
      <input type="text" name="keyword" size="40" value="" />
      <input type="submit" class="submit" value="送出查詢" />
    </form>
    <?php
  }
  
  
  function processSearch()
  {
    if(isset($_POST['keyword']))
      $keyword = $_POST['keyword'];
    
    if($_POST['keyword'] == "")
    {
      $errorMessage = "請輸入您要搜尋的關鍵字";
      displaySearch($errorMessage);
      exit;
    }
    
    $conn = db_connect();
    $sql = "SELECT * FROM threads WHERE subject LIKE '%$keyword%'";
            
    $result = $conn->query($sql);
    
    echo '<h2>---搜尋結果---</h2>';
    
    if($result->num_rows > 0)
    {
      echo '<ul>';
      while($match = $result->fetch_assoc())
      {
        $subject = $match['subject'];
        $thread_id = $match['thread_id'];
        $replace = "<font color='red'>$keyword</font>";
        
        echo '<li><a href="read.php?thread_id='.$thread_id.'">';
        echo str_ireplace($keyword, $replace, $subject);
        echo '</li>';     
      }
      echo '</ul>';      
    }
    else
    {
      echo "找不到您要的東東";
    }    
  }
  
  include("footer.php");
?>