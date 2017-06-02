<?php
// require_once('config.php');
require_once('functions.php');

// セッション開始
// session_start();

// $db['host'] = "localhost";  // DBサーバのURL
// $db['user'] = "root";  // ユーザー名
// $db['pass'] = "root";  // ユーザー名のパスワード
// $db['dbname'] = "php_lesson";  // データベース名

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
// if (isset($_POST["signUp"])) {
  // 1. ユーザIDの入力チェック
  // if (empty($_POST["username"])) {  // 値が空のとき
  //   $errorMessage = 'ユーザーIDが未入力です。';
  // } else if (empty($_POST["password"])) {
  //   $errorMessage = 'パスワードが未入力です。';
  // } else if (empty($_POST["password2"])) {
  //   $errorMessage = 'パスワードが未入力です。';
  // }

  // if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
    // 入力したユーザ名とパスワードを格納
    // $username = $_POST["username"];
    // $password = $_POST["password"];

    // ユーザ名とパスワードが入力されていたら認証する
    // $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

    // エラー処理
    // try {
    //   $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    //   $stmt = $pdo->prepare("INSERT INTO users(username, password) VALUES (?, ?)");
    //   $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT))); // パスワードのハッシュ化
    //   $userid = $pdo->lastinsertid();
    //   $signUpMessage = '登録が完了しました。';
    // } catch (PDOException $e) {
    //   $errorMessage = 'データベースエラー';
    // }
  // } else if($_POST["password"] != $_POST["password2"]) {
  //   $errorMessage = 'パスワードに誤りがあります。';
  // }
// }
?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
      <title>新規登録</title>
    </head>
  <body>
    <h1>新規登録画面</h1>
    <form id="loginForm" name="loginForm" action="store.php" method="POST">
      <fieldset>
        <legend>新規登録フォーム</legend>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
        <label for="username">ユーザー名</label><input type="text" name="username" placeholder="ユーザー名入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
        <br>
        <label for="password">パスワード</label><input type="password" name="password" value="" placeholder="パスワード入力">
        <br>
        <label for="password_confirm">パスワード(確認用)</label><input type="password" name="password_confirm" value="" placeholder="確認用パスワード入力">
        <br>
        <!-- <input type="submit"  name="signUp" value=" 新規登録"> -->
        <button type="submit" name="type" value="signUp">新規登録</button>
      </fieldset>
    </form>
    <br>
    <form action="Login.php">
      <input type="submit" value="戻る">
    </form>
  </body>
</html>