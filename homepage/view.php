<?php
require_once('../templates/header.php');

$recipeId = isset($_GET['recipe_id']) ? intval($_GET['recipe_id']) : 0;
$recipe = getRecipeById($recipeId);
$categories = getCategoriesByRecipeId($recipeId);
$ingredients = getIngredientsForRecipe($recipeId);

$categoryColors = [
    'Meal Type' => 'bg-primary text-white',
    'Cuisine Type' => 'bg-success text-white',
    'Dietary Restrictions' => 'bg-danger text-white',
    'Occasion' => 'bg-warning text-dark',
];
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <a href="browse.php" class="btn btn-outline-secondary mb-3">Back to Browse</a>
            
            <?php if (!empty($recipe['recipe_image'])): ?>
                <img class="img-fluid" style="width: 100%; height: auto; object-fit: cover;" src="../uploads/<?php echo $recipe['recipe_image']; ?>" alt="<?php echo $recipe['recipe_name']; ?>">
            <?php endif; ?>
            <h2 class="mt-3"><strong><?php echo $recipe['recipe_name']; ?></strong></h2>
            <p><strong>Published by:</strong> <?php echo $recipe['username']; ?></p>
            <p><strong>Category:</strong>
                <?php foreach ($categories as $category): ?>
                    <span class="badge <?php echo $categoryColors[$category['category_type']] ?? 'bg-secondary text-white'; ?>">
                        <?php echo $category['category_name']; ?>
                    </span>
                <?php endforeach; ?>
            </p>
            <p><strong>Cooking Time:</strong> <?php echo $recipe['cooking_time']; ?></p>
            <p><strong>Serving Size:</strong> <?php echo $recipe['serving_size']; ?></p>
            <h3>Ingredients</h3>
            <?php if (!empty($ingredients)): ?>
                <ul>
                    <?php foreach ($ingredients as $ingredient): ?>
                        <li><?php echo $ingredient['ingredient_name']; ?> - <?php echo $ingredient['quantity']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No ingredients listed.</p>
            <?php endif; ?>
        </div>       
        <div class="col-md-6">
            <h3>Instructions</h3>
            <?php if (!empty($recipe['instructions'])): ?>
                <p><?php echo $recipe['instructions']; ?></p>
            <?php else: ?>
                <p>No instructions provided.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once('../templates/footer.php'); ?>
