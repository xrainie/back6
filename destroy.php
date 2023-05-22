<?php 
session_start();
unset($_SESSION['login']);
unset($_SESSION['uid']);
session_destroy();
header('Location: ./');
?>