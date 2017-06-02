<?php
require_once('functions.php');

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "root";  // ユーザー名のパスワード
$db['dbname'] = "php_lesson";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
  // 1. ユーザIDの入力チェック
  if (empty($_POST["userid"])) {  // emptyは値が空のとき
    $errorMessage = 'ユーザー名が未入力です。';
  } else if (empty($_POST["password"])) {
    $errorMessage = 'パスワードが未入力です。';
  }
  if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
    // 入力したユーザ名を格納
    $userid = $_POST["userid"];
    // 2. ユーザ名とパスワードが入力されていたら認証する
    $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
    // 3. エラー処理
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
      $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
      $stmt->execute(array($userid));
      $password = $_POST["password"];
      if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($password, $row['password'])) {
          session_regenerate_id(true);
          // 入力したIDのユーザー名を取得
          $id = $row['id'];
          $sql = "SELECT * FROM users WHERE username = $id"; //入力からユーザー名を取得
          $stmt = $pdo->query($sql);
          foreach ($stmt as $row) {
              $row['name'];  // ユーザー名
          }
          $_SESSION["NAME"] = $row['name']; //セッションにユーザー名を格納
          header("Location: index.php"); // メイン画面へ遷移
          exit(); // 処理終了
        } else {
          $errorMessage = 'ユーザー名あるいはパスワードに誤りがあります。';
        }
      } else {
          $errorMessage = 'ユーザー名あるいはパスワードに誤りがあります。';
      }
    } catch (PDOException $e) {
      $errorMessage = 'データ処理でエラーが発生しました';
    }
  }
}
?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ログイン</title>
  </head>
  <body>
    <h1>ログイン画面</h1>
    <form id="loginForm" name="loginForm" action="store.php" method="POST">
      <fieldset>
        <legend>ログインフォーム</legend>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <label for="userid">ユーザー名</label><input type="text" id="userid" name="userid" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
        <br>
        <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
        <br>
        <input type="submit" id="login" name="login" value="ログイン">
      </fieldset>
    </form>
    <br>
    <form action="register.php">
      <fieldset>
        <legend>新規登録フォーム</legend>
        <input type="submit" value="新規登録">
      </fieldset>
    </form>
  </body>
</html>