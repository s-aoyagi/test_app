<?php
session_start();
header("Content-type: text/html; charset=utf-8");
if ($_POST['token'] != $_SESSION['token']){
  echo "不正アクセスの可能性あり";
  exit();
}
header('X-FRAME-OPTIONS: SAMEORIGIN');
//データベース接続
require_once("functions.php");
$dbh = db_connect();
function spaceTrim ($str) {
  $str = preg_replace('/^[ 　]+/u', '', $str);
  // 末尾
  $str = preg_replace('/[ 　]+$/u', '', $str);
}
$errors = array();

if(empty($_POST)) {
  header("Location: login.php");
  exit();
}else{
  $account = isset($_POST['account']) ? $_POST['account'] : NULL;
  $password = isset($_POST['password']) ? $_POST['password'] : NULL;
  $account = spaceTrim($account);
  $password = spaceTrim($password);

  //アカウント入力判定
  if ($account == ''):
    $errors['account'] = "アカウントが入力されていません。";
  elseif(mb_strlen($account)>10):
    $errors['account_length'] = "アカウントは10文字以内で入力して下さい。";
  endif;

  //パスワード入力判定
  if ($password == ''):
    $errors['password'] = "パスワードが入力されていません。";
  elseif(!preg_match('/^[0-9a-zA-Z]{5,30}$/', $_POST["password"])):
    $errors['password_length'] = "パスワードは半角英数字の5文字以上30文字以下で入力して下さい。";
  else:
    $password_hide = str_repeat('*', strlen($password));
  endif;
}
 
//エラーが無ければ実行
if(count($errors) === 0){
  try {
    //例外処理を投げる（スロー）ようにする
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //アカウントで検索
    $statement = $dbh->prepare("SELECT * FROM member WHERE account=(:account) AND flag =1");
    $statement->bindValue(':account', $account, PDO::PARAM_STR);
    $statement->execute();

    //アカウントが一致
    if($row = $statement->fetch()){
      $password_hash = $row[password];
      //パスワードが一致
      if (password_verify($password, $password_hash)) {
        //セッションハイジャック対策
        session_regenerate_id(true);
        $_SESSION['account'] = $account;
        header("Location: index.php");
        exit();
      } else {
        $errors['password'] = "アカウント及びパスワードが一致しません。";
      }
    } else {
      $errors['account'] = "アカウント及びパスワードが一致しません。";
    }
    //データベース接続切断
    $dbh = null;
  }catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
  }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>ログイン確認画面</title>
    <meta charset="utf-8">
  </head>
  <body>
    <h1>ログイン確認画面</h1>
    <?php if(count($errors) > 0): ?>
    <?php foreach($errors as $value) {
        echo "<p>".$value."</p>";
    }S?>
    <input type="button" value="戻る" onClick="history.back()">
    <?php endif; ?>
  </body>
</html>