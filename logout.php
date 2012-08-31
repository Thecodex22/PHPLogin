<?php
setcookie("error", "", time()+2000);
mysql_close();
session_unset();
session_destroy();
header("Location:securelogin.php");
?>