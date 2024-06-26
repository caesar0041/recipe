<!--admin_dashboard/category.php-->
<?php
ob_start();
require_once('../templates/header2.php');

if (isset($_POST['add'])) {
    $category_name = trim($_POST['category_name']);
    $category_type = trim($_POST['category_type']);

    if (empty($category_name)) {
        header('Location: ' . BASE_URL . 'admin_dashboard/category.php?error=1');
        exit;
    }

    $response = addCategory($category_name, $category_type);

    if ($response != FALSE) {
        header('location:' . BASE_URL . 'admin_dashboard/category.php?success=1');
        exit;
    } else {
        header('location:' . BASE_URL . 'admin_dashboard/category.php?error=1');
        exit;
    }
}
ob_end_flush();
?>



<div class="content-wrapper">
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>index.php">Home</a></li>
              <li class="breadcrumb-item active">Add Category</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <?php
                    if (isset($_GET['success']) && $_GET['success'] == 1) {
                        echo '<div class="alert alert-success" >The data has been successfully saved.</div>';
                    } else if (isset($_GET['error']) && $_GET['error'] == 1) {
                        echo '<div class="alert alert-danger" >Error: Unable to save.</div>';
                    }
                    ?>
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Add New Category</h3>
                        </div>
                        <form method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" class="form-control" id="categoryName" name="category_name" placeholder="Enter category name">
                                </div>
                                <div class="form-group">
                                    <label for="category_type">Category Type</label>
                                    <select name="category_type" class="form-control" id="examplecategory_type">
                                        <option value="Meal Type">Meal Type</option>
                                        <option value="Cuisine Type">Cuisine Type</option>
                                        <option value="Dietary Restrictions">Dietary Restrictions</option>
                                        <option value="Occasion">Occasion</option>
                                    </select>
                                </div>
                                <?php
                                if (!empty($error_message)) {
                                    echo '<div class="alert alert-danger">' . $error_message . '</div>';
                                }
                                ?>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <button type="submit" class="btn btn-success" name="add">Add Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<?php require_once('../templates/footer2.php') ?>