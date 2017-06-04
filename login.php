<?php
require_once('functions.php');
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
        <?php if(isset($_SESSION['checkerr'])): ?>
          <p><?php echo $_SESSION['checkerr'] ?></p>
        <?php endif; ?>
        <label for="username">ユーザー名</label><input type="text" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
        <br>
        <label for="password">パスワード</label><input type="password" name="password" value="" placeholder="パスワードを入力">
        <br>
        <button type="submit" name="type" value="login">ログイン</button>
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