<!--logout.php-->
<?php
session_start();
require_once('config.php');
$_SESSION = array();

session_destroy();

header("Location: ".BASE_URL ."index.php");
exit();
?>
