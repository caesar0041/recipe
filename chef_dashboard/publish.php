<?php
ob_start();
require_once('../templates/header3.php');

$categories = getAllCategories();
$csrf_token = generateCsrfToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && verifyCsrfToken($_POST['csrf_token'])) {
    $error = false;
    $recipe_data = [
        'recipe_name' => trim($_POST['recipe_name']),
        'ingredients' => [],
        'cooking_time' => (int)$_POST['cooking_time'],
        'serving_size' => (int)$_POST['serving_size'],
        'instructions' => trim($_POST['instructions']),
        'category_ids' => $_POST['category_id'] ?? [],
        'status' => (int)$_POST['status'],
        'recipe_image' => $_FILES['image']['name'] ?? null
    ];

    foreach ($_POST['ingredient_name'] as $index => $name) {
        $recipe_data['ingredients'][] = [
            'name' => trim($name),
            'quantity' => trim($_POST['quantity'][$index])
        ];
    }

    if (empty($recipe_data['recipe_name']) || empty($recipe_data['instructions']) || empty($recipe_data['ingredients'])) {
        $error = true;
    }

    if (!$error) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $error = true;
                header("Location: " . BASE_URL . "chef_dashboard/publish.php?error=1");
                exit();
            }
        }

        $user_id = $_SESSION['user_id'];
        if (insertRecipe($user_id, $recipe_data)) {
            header("Location: " . BASE_URL . "chef_dashboard/index.php?success=1");
            exit();
        } else {
            header("Location: " . BASE_URL . "chef_dashboard/publish.php?error=1");
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "chef_dashboard/publish.php?error=1");
        exit();
    }
}
ob_end_flush();
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Publish Recipe</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Publish Recipe</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-10">
            <?php
            if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo '<div class="alert alert-success">The data has been successfully saved.</div>';
            } elseif (isset($_GET['error']) && $_GET['error'] == 1) {
                $message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Unable to save.';
                echo '<div class="alert alert-danger">Error: ' . $message . '</div>';
            }
            ?>

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
                                <input type="text" id="recipeName" name="recipe_name" class="form-control">
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
                                        <tr>
                                            <td><input type="text" name="ingredient_name[]" class="form-control"></td>
                                            <td><input type="text" name="quantity[]" class="form-control"></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><label for="cookingTime" class="md-6">Cooking Time (minutes)</label>
                                            <input type="number" id="cookingTime" name="cooking_time" class="form-control"></td>
                                        <td><label for="servingSize" class="md-6">Serving Size</label>
                                            <input type="number" id="servingSize" name="serving_size" class="form-control"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <label for="instructions">Instructions</label>
                                <textarea id="instructions" name="instructions" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="recipeCategories">Categories</label>
                                <div class="row">
                                    <?php foreach ($categories as $category): ?>
                                        <div class="col-sm-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="category_<?php echo $category['category_id']; ?>" name="category_id[]" value="<?php echo $category['category_id']; ?>">
                                                <label class="custom-control-label" for="category_<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Publish Status:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0">Private</option>
                                    <option value="1">Public</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Recipe Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" class="btn btn-secondary">Cancel</a>
                                    <input type="submit" name="submit" value="Publish Recipe" class="btn btn-success float-right">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require_once('../templates/footer2.php') ?>

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
