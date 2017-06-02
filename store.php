<?php
require('functions.php');
$res = checkReferer();
if($res != 'back' && $res != 'create' ){
  header('location: ./index.php');
}elseif($res == 'create'){
  header('location: ./register.php');
}elseif($res == 'index'){
  header('location: ./index.php');
}