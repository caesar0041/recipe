<?php
require_once('../templates/header.php');

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$recipes = searchRecipe($searchQuery);

$categoryColors = [
    'Meal Type' => 'bg-primary text-white',
    'Cuisine Type' => 'bg-success text-white',
    'Dietary Restrictions' => 'bg-danger text-white',
    'Occasion' => 'bg-warning text-dark',
];

function renderRecipeCard($recipe, $categories, $categoryColors) {
    ob_start();
    ?>
    <div class="col-md-3">
        <div class="card mb-4">
            <?php if (!empty($recipe['recipe_image'])): ?>
                <img class="card-img-top" style="width: 100%; height: 300px; max-height: 300px; object-fit: cover;" src="../uploads/<?php echo $recipe['recipe_image']; ?>" alt="<?php echo $recipe['recipe_name']; ?>">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><strong><?php echo $recipe['recipe_name']; ?></strong></h5>
                <p class="card-text"><strong>Published by:</strong> <?php echo $recipe['username']; ?></p>
                <p class="card-text"><strong>Category:</strong>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <span class="badge <?php echo $categoryColors[$category['category_type']] ?? 'bg-secondary text-white'; ?>">
                                <?php echo $category['category_name']; ?>
                            </span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="badge bg-secondary text-white">No category</span>
                    <?php endif; ?>
                </p>
                <a href="view.php?recipe_id=<?php echo $recipe['recipe_id']; ?>" class="btn btn-outline-secondary"><b>View</b></a>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <form method="GET" action="browse.php" class="form-inline w-100 mt-5">
                <div class="input-group w-50 mx-auto">
                    <input type="text" name="search" class="form-control" placeholder="Search for recipes..." value="<?php echo $searchQuery; ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-block btn-warning"><b>Search</b></button>
                    </div>
                </div>
            </form>
            <div class="col-md-12 mt-3 mb-5">
                <div class="card search-results">
                    <div class="card-body">
                        <?php if ($searchQuery): ?>
                            <h5 class="mb-3">Search Results for "<?php echo $searchQuery; ?>"</h5>
                        <?php endif; ?>
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <div class="post col-md-12">
                                    <?php if (!empty($recipes)): ?>
                                        <div class="row justify-content-center">
                                            <?php foreach ($recipes as $recipe): ?>
                                                <?php echo renderRecipeCard($recipe, getCategoriesByRecipeId($recipe['recipe_id']), $categoryColors); ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p>No recipes found.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once('../templates/footer.php'); ?>
