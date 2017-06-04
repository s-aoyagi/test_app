<?php
require_once('functions.php');
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
        <?php if(isset($_SESSION['err'])): ?>
          <p><?php echo $_SESSION['err'] ?></p>
        <?php endif; ?>
        <?php if(isset($_SESSION['msg'])): ?>
          <p><?php echo $_SESSION['msg'] ?></p>
        <?php endif; ?>
        <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
        <label for="username">ユーザー名</label><input type="text" name="username" placeholder="ユーザー名入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
        <br>
        <label for="password">パスワード</label><input type="password" name="password" value="" placeholder="パスワード入力">
        <br>
        <label for="password_confirm">パスワード(確認用)</label><input type="password" name="password_confirm" value="" placeholder="確認用パスワード入力">
        <br>
        <button type="submit" name="type" value="signUp">新規登録</button>
      </fieldset>
    </form>
    <br>
    <form action="Login.php">
      <input type="submit" value="戻る">
    </form>
  </body>
</html>