<?php
ob_start();
require_once('../templates/header2.php');

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$categories = searchCategory($searchQuery);

ob_end_flush();
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Recipe Category Management</h1>
                </div>
                <div class="col-sm-6">
                    <div class="col-md-9">
                        <form method="GET" action="view_category.php" class="form-inline">
                            <div class="input-group w-100">
                                <input type="text" name="search" class="form-control" placeholder="Search category" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-secondary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row row justify-content-center">
                <div class="col-md-9">
                    <div class="card text-center">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Existing Categories</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Category Type</th>
                                        <th>Published Recipe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($categories) {
                                        foreach ($categories as $category) {
                                            echo "<tr>
                                                <td>{$category['category_name']}</td>
                                                <td>{$category['category_type']}</td>
                                                <td>{$category['recipe_count']}</td>
                                            </tr>";
                                        }
                                    } else {
                                        echo '<tr><td colspan="3">No categories found.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once('../templates/footer2.php') ?>
