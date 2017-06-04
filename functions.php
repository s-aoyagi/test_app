<?php
require('connection.php');
session_start();

// エスケープ処理
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

// sessionに暗号化したtokenを入れる
function setToken() {
  $token = sha1(uniqid(mt_rand(),true));
  $_SESSION['token'] = $token;
}

// sessionのチェックを行いcsrf対策を行う
function checkToken($data) {
  if (empty($_SESSION['token']) || ($_SESSION['token'] != $data)){
    $_SESSION['err'] = '不正な操作です';
    header('location: '.$_SERVER['HTTP_REFERER'].'');
    exit();
  }
  return true;
}

function unsetSession() {
  if(!empty($_SESSION['err'])) $_SESSION['err'] = '';
}

function create($data) {
  if(checkToken($data['token'])){
    insertDb($data['todo']);
  }
}
// 全件取得
function index() {
  return $todos = selectAll();
}
// 更新
function update($data) {
  if(checkToken($data['token'])) {
    updateDb($data['id'], $data['todo']);
  }
}
// 詳細の取得
function detail($id) {
  return getSelectData($id); 
}

function checkReferer() {
  $httpArr = parse_url($_SERVER['HTTP_REFERER']);
  return $res = transition($httpArr['path']);
}

function transition($path) {
  unsetSession();
  $data = $_POST;
  // if(isset($data['todo'])) $res = validate($data['todo']);
  if($path === '/index.php' && $data['type'] === 'delete'){
    deleteData($data['id']);
    return 'index';
  }elseif($path === '/register.php'){
    createUser($data);
    return 'create';
  }elseif($path === '/login.php'){
    userCheck($data);
    if(!empty($_SESSION['NAME'])) {
      return 'index';
    } else {
      return 'check';
    }
  }else{
    if(isset($data['todo'])) {
      $res = validateTodo($data['todo']);
      if(!$res || !empty($_SESSION['err'])){
        return 'back';
      }else{
        if($path === '/new.php'){
          create($data);
        }elseif($path === '/edit.php'){
          update($data);
        }
      }
    }
  }
}

function deleteData($id) {
  deleteDb($id);
}

function userCheck($data) {
  $res = validateUserCheck($data['username'],$data['password']);
  if($res && empty($_SESSION['checkerr'])){
    $logincheck = login($data['username'], $data['password']);
    if($logincheck == "") {
      return $_SESSION['checkerr'] = 'ユーザー名もしくはパスワードが違います。';
    } else {
      $_SESSION["NAME"] = $logincheck;
      if (isset($_SESSION["NAME"])) {
        return $_SESSION['NAME'];
      }
    }
  }
}

function validateUserCheck($username, $password) {
  if (empty($username)) {
    return $_SESSION['checkerr'] = 'ユーザー名が未入力です。';
  } else if (empty($password)) {
    return $_SESSION['checkerr'] = 'パスワードが未入力です。';
  }
  $_SESSION['checkerr'] = "";
  return true;
}

function createUser($data){
  $res = validateCreateUser($data['username'],$data['password'],$data['password_confirm']);
  if($res && empty($_SESSION['err'])){
    register($data['username'], $data['password']);
    $_SESSION['msg'] = '登録しました。';
  }
}

function validateTodo($data) {
  return $res = $data != "" ? true : $_SESSION['err'] = '入力がありません'; 
}

function validateCreateUser($username, $password, $password_confirm){
  if (empty($username)) {  // 値が空のとき
    return $_SESSION['err'] = 'ユーザーIDが未入力です。';
  } else if (empty($password)) {
    return $_SESSION['err'] = 'パスワードが未入力です。';
  } else if (empty($password_confirm)) {
    return $_SESSION['err'] = '確認用パスワードが未入力です。';
  } else if($_POST["password"] != $_POST["password_confirm"]) {
    return $_SESSION['err'] = '確認用パスワードに誤りがあります。';
  }
  return true;
}
