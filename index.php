<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>위대한 뮤지션</title>
  </head>
  <body>
    <h1><a href="index.php">The greatest Musician</a></h1>
    <ol>
      <?php
       $list = scandir('./data');
       $i = 0;
       while ($i < count($list)) { //저기 괄호 i가 아니라 a로 해놔서 무한루프 걸렸음
         if ($list[$i] !='.') {
           if ($list[$i] !='..') {
             echo "<li><a href=\"index.php?id=$list[$i]\">$list[$i]</a></li>";
           }
         }
         $i = $i + 1;
       }
       ?>

      <!-- <li><a href="index.php?id=michaeljackson">Michael Jackson</a></li>
      <li><a href="index.php?id=kurtcobain">Kurt Cobain</a></li>
      <li><a href="index.php?id=jeffbuckley">Jeff Buckley</a></li> -->
    </ol>
    <h2>
      <?php
      if (isset($_GET['id'])) {
        echo $_GET['id'];
      } else {
        echo "위대한 뮤지션 세 명을 소개한다.";
      }
       ?>
    </h2>
      <?php
      if (isset($_GET['id'])) {
        echo file_get_contents("data/".$_GET['id']);
      } else {
        echo "당신의 최고는 누구인가?";
      }
       ?>
       <br>
       <?php

       // if (isset($_GET['id'])) {
       //   echo '<img src="./img/'.$_GET['id'].'jpg' ' width="100%">';
       // } else {
       //   echo "img";
       // } 이미지 넣으려다 실패함.
        ?>
  </body>
</html>
