<!--chef_dashboard/delete_recipe.php-->
<?php
require_once('../function.php');

if(isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];
    $result = deleteRecipe($recipe_id);

    if ($result) {
        header("Location: index.php?delete_success=1");
        exit(); 
    } 
    else {
        header("Location: index.php?delete_error=1");
        exit(); 
    }
} 

else {
    header("Location: index.php");
    exit(); 
}
?>