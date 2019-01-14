<?php

$dataFile = 'bbs.dat';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $content = $_POST['content'];
  $user = $_POST['user'];

  $newDate = $content . "\t" . $user . "\n";
}

$fp = fopen($dataFile, 'a');
fwrite($fp, $newDate);
fclose($fp);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>BBS</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <div class="container">
    <h1 class="heading">掲示板</h1>
    <form class="formArea" method="post">
      <div class="inputField">
        <label for="content">content: </label><input id="content" type="text" name="content">
      </div>
      <div class="inputField">
      <label for="user">user: </label><input id="user" type="text" name="user">
      </div>
      <input type="submit" value="投稿する">
    </form>
    <h2 class="subHeading">一覧</h2>
    <ul>
      <li>投稿はありません</li>
    </ul>
  </div>


  
</body>
</html>