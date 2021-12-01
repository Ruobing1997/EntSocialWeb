<?php
session_start();

setcookie ("Userid", '', time()- (3600));
setcookie ("UserName", '', time()- (3600));

session_destroy();



header("Location:index.php");
?>