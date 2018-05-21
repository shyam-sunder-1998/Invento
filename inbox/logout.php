<?php

include "../db.php";
session_start();
unset($_SESSION['name']);

session_destroy();
header("Location:http://localhost/email/intro");
exit;
?>