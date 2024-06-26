<?php
ob_start();
require_once('../templates/header3.php');

$recipe_id = $_GET['recipe_id'] ?? null;
if (!$recipe_id) {
    header("Location: " . BASE_URL . "chef_dashboard/publish.php");
    exit;
}

$recipe = getRecipeById($recipe_id);
$categories = getAllCategories();
$recipeCategories = getCategoriesByRecipeId($recipe_id);
$recipeIngredients = getIngredientsForRecipe($recipe_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && verifyCsrfToken($_POST['csrf_token'])) {
    $error = false;

    // Basic validation
    if (empty($_POST['recipe_name']) || empty($_POST['ingredient_name']) || empty($_POST['quantity']) || 
        empty($_POST['cooking_time']) || empty($_POST['serving_size']) || empty($_POST['instructions']) || 
        empty($_POST['category_id']) || !isset($_POST['status'])) {
        $error = true;
    }

    if ($error) {
        header("Location: " . BASE_URL . "chef_dashboard/edit_recipe.php?recipe_id=" . $recipe_id . "&error=1");
        exit();
    }

    $recipe_data = [
        'recipe_name' => trim($_POST['recipe_name']),
        'ingredients' => array_map(function($name, $quantity) {
            return ['name' => trim($name), 'quantity' => trim($quantity)];
        }, $_POST['ingredient_name'], $_POST['quantity']),
        'cooking_time' => (int) trim($_POST['cooking_time']),
        'serving_size' => (int) trim($_POST['serving_size']),
        'instructions' => trim($_POST['instructions']),
        'category_ids' => $_POST['category_id'] ?? [],
        'status' => (int) trim($_POST['status'])
    ];

    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        
        if (in_array($fileType, $allowedTypes)) {
            $recipe_data['recipe_image'] = $_FILES['image']['name'];
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            // Invalid file type
            header("Location: " . BASE_URL . "chef_dashboard/edit_recipe.php?recipe_id=" . $recipe_id . "&error=2");
            exit();
        }
    }

    if (updateRecipe($recipe_id, $recipe_data)) {
        header("Location: " . BASE_URL . "chef_dashboard/manage_recipe.php?success=1");
        exit;
    } else {
        echo "There was an error processing your request. Please try again later.";
    }
}

$csrf_token = generateCsrfToken();
ob_end_flush();
?>

<div class="content-wrapper">
<?php
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="alert alert-success">The data has been successfully saved.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
    echo '<div class="alert alert-danger">Error: Unable to save.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] == 2) {
    echo '<div class="alert alert-danger">Error: Invalid file type.</div>';
}
?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Recipe</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Recipe</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Recipe Details</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="form-group">
                                <label for="recipeName">Recipe Name</label>
                                <input type="text" id="recipeName" name="recipe_name" class="form-control" value="<?php echo $recipe['recipe_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="ingredients">Ingredients</label>
                                <table class="table table-bordered" id="ingredientsTable">
                                    <thead>
                                        <tr>
                                            <th>Ingredient Name</th>
                                            <th>Quantity</th>
                                            <th><button type="button" class="btn btn-success" onclick="addIngredientRow()">Add Ingredient</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recipeIngredients as $ingredient): ?>
                                            <tr>
                                                <td><input type="text" name="ingredient_name[]" class="form-control" value="<?php echo $ingredient['ingredient_name']; ?>"></td>
                                                <td><input type="text" name="quantity[]" class="form-control" value="<?php echo $ingredient['quantity']; ?>"></td>
                                                <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <label for="cookingTime">Cooking Time (minutes)</label>
                                            <input type="number" id="cookingTime" name="cooking_time" class="form-control" value="<?php echo $recipe['cooking_time']; ?>">
                                        </td>
                                        <td>
                                            <label for="servingSize">Serving Size</label>
                                            <input type="number" id="servingSize" name="serving_size" class="form-control" value="<?php echo $recipe['serving_size']; ?>">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <label for="instructions">Instructions</label>
                                <textarea id="instructions" name="instructions" class="form-control" rows="4"><?php echo $recipe['instructions']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="recipeCategories">Categories</label>
                                <div class="row">
                                    <?php foreach ($categories as $category): ?>
                                        <div class="col-sm-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="category_<?php echo $category['category_id']; ?>" name="category_id[]" value="<?php echo $category['category_id']; ?>" <?php echo in_array($category['category_id'], array_column($recipeCategories, 'category_id')) ? 'checked' : ''; ?>>
                                                <label class="custom-control-label" for="category_<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Publish Status:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0" <?php echo $recipe['status'] == 0 ? 'selected' : ''; ?>>Private</option>
                                    <option value="1" <?php echo $recipe['status'] == 1 ? 'selected' : ''; ?>>Public</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Recipe Image</label>
                                <input type="file" name="image" class="form-control">
                                <?php if (!empty($recipe['recipe_image'])): ?>
                                    <img src="<?php echo BASE_URL . 'uploads/' . $recipe['recipe_image']; ?>" alt="Recipe Image" style="max-width: 200px; margin-top: 10px;">
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" class="btn btn-secondary">Cancel</a>
                                    <input type="submit" name="submit" value="Update Recipe" class="btn btn-success float-right">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once('../templates/footer2.php'); ?>

<script>
function addIngredientRow() {
    var table = document.getElementById('ingredientsTable').getElementsByTagName('tbody')[0];
    var newRow = table.insertRow();
    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    var cell3 = newRow.insertCell(2);
    cell1.innerHTML = '<input type="text" name="ingredient_name[]" class="form-control">';
    cell2.innerHTML = '<input type="text" name="quantity[]" class="form-control">';
    cell3.innerHTML = '<button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button>';
}

function removeRow(button) {
    var row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

$(function () {
    $('#instructions').summernote();
});
</script>
