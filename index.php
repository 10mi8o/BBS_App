<?php

$dataFile = 'bbs.dat';

session_start();

function setToken(){
  $token = sha1(uniqid(mt_rand(), true));
  $_SESSION['token'] = $token;
}

function checkToken(){
  if(empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token'])){
    echo "不正なPOSTが行われました";
    exit;
  }
}

function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

if($_SERVER['REQUEST_METHOD'] == 'POST' &&
isset($_POST['content']) &&
isset($_POST['user'])){

  checkToken();

  $content = trim($_POST['content']);
  $user = trim($_POST['user']);

  if($content !== ''){
    $user = ($user === '') ? 'NoName' : $user;

    $content = str_replace("\t", ' ', $content);
    $user = str_replace("\t", ' ', $user);

    $postedTime = date('Y-m-d H:i:s');

    $newDate = $content . "\t" . $user . "\t" . $postedTime . "\n";
    $fp = fopen($dataFile, 'a');
    fwrite($fp, $newDate);
    fclose($fp);
  }
}else {
  setToken();
}

$posts = file($dataFile, FILE_IGNORE_NEW_LINES);
$posts = array_reverse($posts);

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
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
    </form>
    <h2 class="subHeading">一覧(<?php echo count($posts); ?>)件</h2>
    <ul>
      <?php if(count($posts)) : ?>
        <?php foreach ($posts as $post) : ?>
        <?php list($content, $user, $postedTime) = explode("\t", $post); ?>
        <li>
          <?php echo h($content); ?> (<?php echo h($user); ?>) - <?php echo h($postedTime); ?>
        </li>
        <?php endforeach; ?>
      <?php else : ?>
      <li>投稿はありません</li>
      <?php endif; ?>
    </ul>
  </div>


  
</body>
</html>