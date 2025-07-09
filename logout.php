<?php
include_once './config/config.php';
initSession();
session_destroy();
header('Location: index.php');
exit();
?>