<!--admin_dashboard/user_delete.php-->
<?php
require_once('../function.php');

if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $result = deleteUser($user_id);

    if ($result) {
        header("Location: users.php?delete_success=1");
        exit(); 
    } 
    else {
        header("Location: users.php?delete_error=1");
        exit(); 
    }
} 

else {
    header("Location: users.php");
    exit(); 
}
?>
